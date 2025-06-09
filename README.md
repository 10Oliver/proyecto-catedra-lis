# 📦 Cuponera SV – Proyecto Web Laravel

**Cuponera SV** es una aplicación web en Laravel diseñada para gestionar y vender cupones de descuento en línea. Cubre el ciclo completo de registro de empresas ofertantes, aprobación de solicitudes, publicación de ofertas, registro de clientes, proceso de compra de cupones (simulado) y generación de facturas, con un dashboard administrativo de métricas.

---

## 👥 Integrantes del equipo

- Oliver Alejandro Erazo Reyes – ER231663
- Vladimir Alexander Ayala Sánchez – AS180120
- Melissa Vanina López Peña – LP223029
- Bryan Rubén De Paz Rivera – DR202095
- Rodrigo André Henríquez López – HL211477

---

## 📋 Funcionalidades Implementadas

- ✅ Registro e inicio de sesión para **Clientes**, **Empresas** y **Administradores**
- ✅ Registro de solicitudes de empresas  
- ✅ Aprobación y rechazo de empresas por parte del administrador  
- ✅ Asignación de porcentaje de comisión a empresas aprobadas  
- ✅ Publicación y gestión de **ofertas**: título, precio regular/oferta, fechas, límite de canje, cantidad (opcional), descripción, estado  
- ✅ Visualización pública de ofertas activas (sin login)  
- ✅ Registro de clientes mayores de 18 años  
- ✅ Proceso de compra de cupones (simulado):
  - Validación de tarjeta (número, vencimiento > hoy, CVV)  
  - Límite de 5 cupones por misma oferta  
- ✅ Generación de **facturas PDF** con código único y QR por cupón  
- ✅ Historial de compras de cliente  
- ✅ Recuperación de contraseña según rol  
- ✅ **Dashboard Administrativo** con:
  - KPI cards: empresas (aprobadas/pendientes), usuarios (totales/nuevos), ofertas, cupones vendidos, ingresos, ganancias  
  - Filtro de rango de fechas  
  - Gráfica interactiva de Ingresos vs Ganancias por mes  
  - Tabla con estadísticas detalladas por empresa (cupones vendidos, total ventas, total ganancias)  
- ✅ Gestión de usuarios de empresa  
- ✅ Gestión CRUD de administradores  
- ✅ Redirección automática según rol después del login  

---

## 🧰 Tecnologías

- **Backend:** PHP 8.2+, Laravel 12, Fortify  
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Chart.js  
- **Base de datos:** MySQL  
- **Otras librerías:** GD (para QR y thumbnails), DomPDF (facturas), chillerlan/php-qrcode

---

## 🚀 Instalación

> **Requisitos previos**  
> - PHP ≥ 8.2  
> - Composer  
> - Node.js ≥ 16  
> - MySQL

## 🔧 Configuración
> [!IMPORTANT]
> El proyecto requiere del gestor de paquetes `composer` para su uso, y este no se encuentra instalado por defecto, por lo que es obligatoria su instalación.

El proyecto está pensado para utilizar `MySQL`, y posee características para envío y recepción de archivos internamente y externamente con otras **API'S**, por lo que es necesario realizar la siguiente modificación en el archivo `php.ini`.

```
;extension=gd // Descomentar esta línea
```

1. Clonar el repositorio
```bash
git clone https://github.com/10Oliver/proyecto-catedra-lis.git
cd cuponera-sv
```
2. Instalar dependencias
```bash
composer install
npm install
```
3. Configurar .env
```bash
cp .env.example .env
php artisan key:generate
```
4. Modificar .env
```bash
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_catedra_lis
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
5. Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```
Esto va a generar las tablas necesarias y un usuario con rol de Administrador:
- Email: admin@cuponera.com
- Contraseña: Admin123.
6. Compilar assets
```bash
npm run dev
```
Para producción:
```bash
npm run build
```
7. Levantar el servidor
```bash
php artisan serve
```
Nota:

Login cliente: http://127.0.0.1:8000/iniciar-sesion

Login privado (empresas y admin): http://127.0.0.1:8000/privada/iniciar-sesion

Enviar Solicitud de empresa: http://127.0.0.1:8000/empresa/solicitud

## 📂 Estructura de carpetas destacadas

- `app/Http/Controllers` – Controladores agrupados por rol: Administrador, Empresa, Cliente  
- `app/Models` – Modelos con relaciones
- `app/Actions/Fortify` – Lógica personalizada para autenticación, registro y recuperación  
- `resources/views` – Vistas Blade separadas por tipo de usuario  
- `database/migrations` – Migraciones para todas las entidades del sistema  
- `database/seeders` – Seeders para roles y administrador por defecto

## 📎 Recursos adicionales

- [Tablero en Trello](https://trello.com/invite/b/681518e87a85c59e9083a154/ATTIcb7d39e2aac20be0c609fe718bc840810B6E3D70/proyecto-de-catedra-lis941) – Seguimiento del desarrollo










