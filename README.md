# cdo.solutions — Web corporativa (WordPress + tema custom)

Web de [cdo.solutions](https://cdo.solutions) — Centro de Desarrollo Online.

Software propio + servicios para empresas omnicanal con tienda online y tiendas físicas. Cobertura España y mercado europeo. Soporte presencial en Gipuzkoa, transporte local en País Vasco.

---

## Stack

- **WordPress** (imagen oficial `wordpress:latest`, PHP 8.3, Apache)
- **MySQL 8.0**
- **Docker Compose** (local + producción)
- **Tema custom** `cdo-solutions` (Tailwind CDN + Plus Jakarta Sans + Material Symbols)
- **Plugin** Adapta RGPD (cookies + páginas legales auto-generadas)

## Estructura del repo

```
.
├── docker-compose.yml          ← Local dev (puertos 8080 + 8081 phpMyAdmin)
├── docker-compose.prod.yml     ← Producción / EasyPanel (sin puertos)
├── apache-override.conf        ← AllowOverride All para permalinks
├── .env.example                ← Plantilla de variables
├── db/initial.sql.gz           ← Dump inicial de la BD (páginas + CPT + opciones)
└── wp-content/themes/cdo-solutions/  ← El tema (lo único versionado dentro de wp-content)
```

---

## 🖥️ Local (desarrollo)

```bash
cp .env.example .env
docker compose up -d
```

- Web: http://localhost:8080
- phpMyAdmin: http://localhost:8081
- Admin: http://localhost:8080/wp-admin/

Cambios en el tema (`wp-content/themes/cdo-solutions/`) son inmediatos — están bind-mount.

---

## 🚀 Deploy en EasyPanel

### 1. Crea la app en EasyPanel

1. Panel de EasyPanel → **+ Service** → **App**
2. Tipo: **Compose**
3. **Source**: Git Repository
4. URL: `https://github.com/<tu-usuario>/cdo-web.git`
5. Branch: `main`
6. Compose file: `docker-compose.prod.yml`

### 2. Variables de entorno

En la pestaña **Environment**, configura:

```
MYSQL_ROOT_PASSWORD=<genera con: openssl rand -base64 24>
MYSQL_DATABASE=wordpress
MYSQL_USER=wp_user
MYSQL_PASSWORD=<genera con: openssl rand -base64 24>
```

### 3. Dominio + SSL

1. Pestaña **Domains** → **+ Add Domain**
2. Host: `cdo.solutions`
3. Service: `wordpress`
4. Port: `80`
5. HTTPS: ✅ (Let's Encrypt automático)

> Asegúrate de tener un registro DNS `A` apuntando `cdo.solutions` al IP de tu VPS antes de añadir el dominio (sino el certificado SSL falla).

### 4. Deploy + import inicial

1. **Deploy** desde el panel
2. Espera a que los 2 contenedores estén `running`
3. Abre la consola del contenedor `wordpress` (botón **Console** en EasyPanel)
4. Importa la BD inicial:

```bash
# Esperar que MySQL esté listo (1-2 min en primer arranque)
wp db import /var/www/html/db/initial.sql.gz --allow-root \
  || (gunzip -c /var/www/html/db/initial.sql.gz | wp db import - --allow-root)

# Si WP-CLI no está instalado en el contenedor:
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
  && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp
```

5. Cambia las URLs internas de la BD a tu dominio:

```bash
wp search-replace 'http://localhost:8080' 'https://cdo.solutions' --allow-root --skip-columns=guid
wp option update siteurl 'https://cdo.solutions' --allow-root
wp option update home    'https://cdo.solutions' --allow-root
wp rewrite flush --hard --allow-root
```

6. Cambia la contraseña del admin:

```bash
wp user update admin --user_pass='<NUEVA_PASSWORD_FUERTE>' --allow-root
# Si el usuario admin no existe (el dump no lo trae), créalo:
wp user create admin tu@email.com --role=administrator --user_pass='<PASS>' --allow-root
```

7. Verifica:

```bash
curl -sI https://cdo.solutions/ | head -3
# Debe responder HTTP/2 200
```

### 5. Plugin de cookies (Adapta RGPD)

El plugin no se incluye en el repo (los plugins están en `.gitignore`). En el primer deploy, instálalo desde el admin:

```bash
wp plugin install adapta-rgpd --activate --allow-root
```

Las páginas legales (Aviso, Cookies, Personalizar Cookies) ya están en el dump y enlazadas desde el footer.

---

## 🔄 Actualizar la web (deploy de cambios)

Cualquier cambio en el tema `wp-content/themes/cdo-solutions/`:

```bash
git add .
git commit -m "feat: descripción del cambio"
git push
```

En EasyPanel → tu app → botón **Redeploy** (o configura webhook para auto-deploy desde GitHub).

El tema está bind-mount → al hacer pull + restart se aplica el cambio en segundos. La BD y los uploads NO se tocan.

---

## 🗄️ Backup

Datos persistentes (en volúmenes de Docker):

- **`cdo_db`** — toda la BD (páginas, CPTs, opciones, usuarios, cookies guardadas)
- **`cdo_wp_data`** — `/var/www/html` completo (incluye `wp-content/uploads/` y plugins instalados)

Backup recomendado desde EasyPanel:
- BD: `wp db export backup-$(date +%F).sql --allow-root` (a un volumen de backup)
- Uploads: copia de `/var/www/html/wp-content/uploads/`

EasyPanel también ofrece backups automáticos de volúmenes en su pestaña **Backups**.

---

## 🛠️ Tema custom — características

El tema `cdo-solutions` incluye:

- **CPT `cdo_software`** — productos software (cdo.mail, cdo.chat, cdo.screen) con calculadora de precios escalable
- **CPT `cdo_solucion`** — áreas de servicio (Soporte, Transporte, Mantenimiento)
- **CPT `cdo_contact_msg`** — almacena consultas del formulario de contacto + email automático al admin
- **Schema.org** — Organization, WebSite, Service, SoftwareApplication, LocalBusiness, FAQPage, BreadcrumbList
- **Open Graph + Twitter Cards** — meta tags para compartir
- **Animaciones JS** — reveals on scroll, contadores, charts, calculadora interactiva
- **Mobile-first responsive** — hamburguesa, dropdown desktop / accordion móvil
- **Sin plugins de SEO** — todo el SEO/GEO está integrado en el tema

---

## 📞 Soporte

Carlos Daniel Ojeda · cdo.solutions · Gipuzkoa
