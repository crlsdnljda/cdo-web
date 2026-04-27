<?php
/**
 * Contact form: handler + CPT para almacenar y revisar las consultas.
 *
 * - El formulario de /contacto/ envía a admin-post.php con action=cdo_contact_form
 * - Aquí se valida, se guarda como entrada del CPT cdo_contact_msg
 * - Se manda email de aviso al admin del sitio
 * - En el admin de WP aparece "Consultas" en el menú lateral
 *
 * @package CdoSolutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- CPT cdo_contact_msg (privado, solo admin) ---------- */

function cdo_register_cpt_contact_msg() {
    $labels = array(
        'name'               => _x( 'Consultas',  'post type general name',  'cdo-solutions' ),
        'singular_name'      => _x( 'Consulta',   'post type singular name', 'cdo-solutions' ),
        'menu_name'          => __( 'Consultas',                              'cdo-solutions' ),
        'all_items'          => __( 'Todas las consultas',                    'cdo-solutions' ),
        'edit_item'          => __( 'Ver consulta',                           'cdo-solutions' ),
        'view_item'          => __( 'Ver consulta',                           'cdo-solutions' ),
        'search_items'       => __( 'Buscar consultas',                       'cdo-solutions' ),
        'not_found'          => __( 'No hay consultas todavía.',              'cdo-solutions' ),
        'not_found_in_trash' => __( 'Papelera vacía.',                        'cdo-solutions' ),
    );

    register_post_type( 'cdo_contact_msg', array(
        'labels'              => $labels,
        'description'         => __( 'Consultas recibidas por el formulario de contacto.', 'cdo-solutions' ),
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => false,
        'menu_position'       => 23,
        'menu_icon'           => 'dashicons-email-alt',
        'capability_type'     => 'post',
        'capabilities'        => array(
            // No queremos que se creen "consultas" desde el admin manualmente.
            'create_posts' => 'do_not_allow',
        ),
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'has_archive'         => false,
        'rewrite'             => false,
        'supports'            => array( 'title' ),
    ) );

    // Estado: nuevo → leído → respondido (categorización ligera)
    register_taxonomy( 'cdo_contact_status', 'cdo_contact_msg', array(
        'label'             => __( 'Estado', 'cdo-solutions' ),
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'rewrite'           => false,
    ) );
}
add_action( 'init', 'cdo_register_cpt_contact_msg' );

/**
 * Crear los términos por defecto del estado al activar el tema.
 */
function cdo_contact_seed_status_terms() {
    foreach ( array(
        'nuevo'      => __( 'Nuevo',      'cdo-solutions' ),
        'leido'      => __( 'Leído',      'cdo-solutions' ),
        'respondido' => __( 'Respondido', 'cdo-solutions' ),
        'spam'       => __( 'Spam',       'cdo-solutions' ),
    ) as $slug => $name ) {
        if ( ! term_exists( $slug, 'cdo_contact_status' ) ) {
            wp_insert_term( $name, 'cdo_contact_status', array( 'slug' => $slug ) );
        }
    }
}
add_action( 'init', 'cdo_contact_seed_status_terms', 100 );

/* ---------- Handler del formulario ---------- */

/**
 * Procesa el envío del formulario público de /contacto/.
 */
function cdo_handle_contact_form() {
    $back = wp_get_referer() ?: home_url( '/contacto/' );

    // Verificación nonce
    if ( empty( $_POST['cdo_contact_nonce'] ) || ! wp_verify_nonce( $_POST['cdo_contact_nonce'], 'cdo_contact' ) ) {
        wp_safe_redirect( add_query_arg( 'cdo_msg', 'nonce', $back ) );
        exit;
    }

    // Honeypot anti-bot básico (campo invisible que no debe llenarse)
    if ( ! empty( $_POST['cdo_website'] ) ) {
        // Bot — fingimos éxito y descartamos
        wp_safe_redirect( add_query_arg( 'cdo_msg', 'sent', $back ) );
        exit;
    }

    // Recoger + sanear
    $name    = sanitize_text_field( wp_unslash( $_POST['cdo_name']    ?? '' ) );
    $email   = sanitize_email(      wp_unslash( $_POST['cdo_email']   ?? '' ) );
    $company = sanitize_text_field( wp_unslash( $_POST['cdo_company'] ?? '' ) );
    $phone   = sanitize_text_field( wp_unslash( $_POST['cdo_phone']   ?? '' ) );
    $topic   = sanitize_text_field( wp_unslash( $_POST['cdo_topic']   ?? '' ) );
    $message = sanitize_textarea_field( wp_unslash( $_POST['cdo_message'] ?? '' ) );
    $privacy = ! empty( $_POST['cdo_privacy'] );

    // Validación mínima
    if ( ! $name || ! is_email( $email ) || ! $message || ! $privacy ) {
        wp_safe_redirect( add_query_arg( 'cdo_msg', 'invalid', $back ) );
        exit;
    }

    // Guardar como entrada del CPT
    $title = sprintf(
        /* translators: 1: nombre, 2: tema (o "general") */
        __( '%1$s — %2$s', 'cdo-solutions' ),
        $name,
        $topic ?: 'general'
    );

    $post_id = wp_insert_post( array(
        'post_type'   => 'cdo_contact_msg',
        'post_status' => 'publish',
        'post_title'  => $title,
    ), true );

    if ( is_wp_error( $post_id ) || ! $post_id ) {
        wp_safe_redirect( add_query_arg( 'cdo_msg', 'error', $back ) );
        exit;
    }

    update_post_meta( $post_id, '_cdo_msg_name',    $name );
    update_post_meta( $post_id, '_cdo_msg_email',   $email );
    update_post_meta( $post_id, '_cdo_msg_company', $company );
    update_post_meta( $post_id, '_cdo_msg_phone',   $phone );
    update_post_meta( $post_id, '_cdo_msg_topic',   $topic );
    update_post_meta( $post_id, '_cdo_msg_message', $message );
    update_post_meta( $post_id, '_cdo_msg_ip',      cdo_contact_client_ip() );
    update_post_meta( $post_id, '_cdo_msg_ua',      isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '' );

    // Estado inicial: nuevo
    wp_set_object_terms( $post_id, 'nuevo', 'cdo_contact_status' );

    // Email al admin
    $admin_email = get_option( 'admin_email' );
    if ( $admin_email ) {
        $subject = sprintf(
            /* translators: 1: nombre */
            __( '[cdo.solutions] Nueva consulta de %s', 'cdo-solutions' ),
            $name
        );
        $body  = "Nueva consulta recibida en cdo.solutions\n";
        $body .= "------------------------------------------\n\n";
        $body .= "Nombre:   {$name}\n";
        $body .= "Email:    {$email}\n";
        $body .= ( $company ? "Empresa:  {$company}\n" : '' );
        $body .= ( $phone   ? "Teléfono: {$phone}\n"   : '' );
        $body .= "Tema:     {$topic}\n\n";
        $body .= "Mensaje:\n{$message}\n\n";
        $body .= "------------------------------------------\n";
        $body .= "Ver en admin: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' ) . "\n";

        wp_mail(
            $admin_email,
            $subject,
            $body,
            array(
                'Reply-To: ' . $name . ' <' . $email . '>',
            )
        );
    }

    wp_safe_redirect( add_query_arg( 'cdo_msg', 'sent', $back ) );
    exit;
}
add_action( 'admin_post_cdo_contact_form',        'cdo_handle_contact_form' );
add_action( 'admin_post_nopriv_cdo_contact_form', 'cdo_handle_contact_form' );

function cdo_contact_client_ip() {
    foreach ( array( 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ) as $key ) {
        if ( ! empty( $_SERVER[ $key ] ) ) {
            $ip = explode( ',', $_SERVER[ $key ] )[0];
            return sanitize_text_field( trim( $ip ) );
        }
    }
    return '';
}

/* ---------- Listado en admin: columnas personalizadas ---------- */

function cdo_contact_msg_columns( $cols ) {
    return array(
        'cb'              => $cols['cb']  ?? '',
        'title'           => __( 'Asunto',   'cdo-solutions' ),
        'cdo_msg_email'   => __( 'Email',    'cdo-solutions' ),
        'cdo_msg_company' => __( 'Empresa',  'cdo-solutions' ),
        'cdo_msg_topic'   => __( 'Tema',     'cdo-solutions' ),
        'taxonomy-cdo_contact_status' => __( 'Estado', 'cdo-solutions' ),
        'date'            => __( 'Recibida', 'cdo-solutions' ),
    );
}
add_filter( 'manage_cdo_contact_msg_posts_columns', 'cdo_contact_msg_columns' );

function cdo_contact_msg_column_value( $col, $post_id ) {
    if ( 'cdo_msg_email' === $col ) {
        $email = get_post_meta( $post_id, '_cdo_msg_email', true );
        if ( $email ) {
            echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
        } else {
            echo '—';
        }
    }
    if ( 'cdo_msg_company' === $col ) {
        echo esc_html( get_post_meta( $post_id, '_cdo_msg_company', true ) ?: '—' );
    }
    if ( 'cdo_msg_topic' === $col ) {
        echo esc_html( get_post_meta( $post_id, '_cdo_msg_topic', true ) ?: '—' );
    }
}
add_action( 'manage_cdo_contact_msg_posts_custom_column', 'cdo_contact_msg_column_value', 10, 2 );

/* ---------- Meta box read-only en la edición ---------- */

function cdo_contact_msg_meta_box() {
    add_meta_box(
        'cdo_contact_msg_details',
        __( 'Datos de la consulta', 'cdo-solutions' ),
        'cdo_contact_msg_render_meta',
        'cdo_contact_msg',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'cdo_contact_msg_meta_box' );

function cdo_contact_msg_render_meta( $post ) {
    $name    = get_post_meta( $post->ID, '_cdo_msg_name',    true );
    $email   = get_post_meta( $post->ID, '_cdo_msg_email',   true );
    $company = get_post_meta( $post->ID, '_cdo_msg_company', true );
    $phone   = get_post_meta( $post->ID, '_cdo_msg_phone',   true );
    $topic   = get_post_meta( $post->ID, '_cdo_msg_topic',   true );
    $message = get_post_meta( $post->ID, '_cdo_msg_message', true );
    $ip      = get_post_meta( $post->ID, '_cdo_msg_ip',      true );
    $ua      = get_post_meta( $post->ID, '_cdo_msg_ua',      true );
    ?>
    <style>
        .cdo-msg-grid { display:grid; grid-template-columns: 140px 1fr; gap: 10px 18px; align-items:start; padding: 8px 0; }
        .cdo-msg-grid > dt { font-weight:600; color:#1d2327; }
        .cdo-msg-grid > dd { margin:0; }
        .cdo-msg-message {
            background: #f6f7f7;
            border: 1px solid #dcdcde;
            padding: 12px 14px;
            border-radius: 4px;
            white-space: pre-wrap;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 13px;
            line-height: 1.5;
        }
        .cdo-msg-actions { margin-top: 16px; display:flex; gap:8px; flex-wrap:wrap; }
        .cdo-msg-actions .button { display:inline-flex; align-items:center; gap:6px; }
        .cdo-msg-meta { color:#646970; font-size:12px; margin-top:14px; padding-top:10px; border-top:1px solid #f0f0f1; }
    </style>
    <dl class="cdo-msg-grid">
        <dt><?php esc_html_e( 'Nombre',  'cdo-solutions' ); ?></dt><dd><?php echo esc_html( $name ?: '—' ); ?></dd>
        <dt><?php esc_html_e( 'Email',   'cdo-solutions' ); ?></dt><dd><?php echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '—'; ?></dd>
        <dt><?php esc_html_e( 'Empresa', 'cdo-solutions' ); ?></dt><dd><?php echo esc_html( $company ?: '—' ); ?></dd>
        <dt><?php esc_html_e( 'Teléfono','cdo-solutions' ); ?></dt><dd><?php echo $phone ? '<a href="tel:' . esc_attr( $phone ) . '">' . esc_html( $phone ) . '</a>' : '—'; ?></dd>
        <dt><?php esc_html_e( 'Tema',    'cdo-solutions' ); ?></dt><dd><?php echo esc_html( $topic ?: '—' ); ?></dd>
        <dt><?php esc_html_e( 'Mensaje', 'cdo-solutions' ); ?></dt>
        <dd><div class="cdo-msg-message"><?php echo esc_html( $message ?: '' ); ?></div></dd>
    </dl>

    <?php if ( $email ) : ?>
        <div class="cdo-msg-actions">
            <a class="button button-primary" href="<?php echo esc_url( 'mailto:' . $email . '?subject=' . rawurlencode( 'Re: ' . $post->post_title ) ); ?>">
                ✉ <?php esc_html_e( 'Responder por email', 'cdo-solutions' ); ?>
            </a>
            <?php if ( $phone ) : ?>
                <a class="button" href="<?php echo esc_url( 'tel:' . $phone ); ?>">📞 <?php esc_html_e( 'Llamar', 'cdo-solutions' ); ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="cdo-msg-meta">
        <?php
        printf(
            /* translators: 1: IP, 2: User Agent */
            esc_html__( 'Recibida desde IP %1$s · UA: %2$s', 'cdo-solutions' ),
            esc_html( $ip ?: '—' ),
            esc_html( $ua ?: '—' )
        );
        ?>
    </div>
    <?php
}

/* ---------- Mostrar resultado en /contacto/ tras submit ---------- */

function cdo_contact_form_notice() {
    if ( ! is_page() || empty( $_GET['cdo_msg'] ) ) { return ''; }
    $code = sanitize_key( $_GET['cdo_msg'] );

    $messages = array(
        'sent'    => array( 'ok',  __( '¡Mensaje enviado! Te respondemos en menos de 24 horas.',        'cdo-solutions' ) ),
        'invalid' => array( 'err', __( 'Faltan campos obligatorios o el email no es válido.',           'cdo-solutions' ) ),
        'nonce'   => array( 'err', __( 'La sesión ha expirado. Por favor, recarga la página y reenvía.', 'cdo-solutions' ) ),
        'error'   => array( 'err', __( 'Hubo un error al enviar el mensaje. Inténtalo de nuevo.',       'cdo-solutions' ) ),
    );
    if ( empty( $messages[ $code ] ) ) { return ''; }
    list( $type, $text ) = $messages[ $code ];

    $bg = 'ok' === $type ? 'bg-primary-container/30 border-primary-container/60' : 'bg-tertiary/15 border-tertiary/40';
    return sprintf(
        '<div class="mb-6 p-4 rounded-lg border %s text-sm font-medium text-on-surface">%s</div>',
        esc_attr( $bg ),
        esc_html( $text )
    );
}
