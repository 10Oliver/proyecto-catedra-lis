# 📦 Cuponera SV – Proyecto Web Laravel (Fase 1)

**Cuponera SV** es una plataforma web desarrollada con Laravel, orientada a la venta de cupones de descuento en línea. Esta aplicación permite la interacción de tres tipos de usuarios: **Administradores**, **Empresas** y **Clientes**.

Este repositorio contiene la implementación completa de la **Fase 1** del proyecto académico de la materia *Lenguajes Interpretados en el Servidor*.

---

## 👥 Integrantes del equipo

- Oliver Alejandro Erazo Reyes – ER231663
- Vladimir Alexander Ayala Sánchez – AS180120
- Melissa Vanina López Peña – LP223029  
- David Ernesto Ramos Vásquez – RV230544  
- Bryan Rubén De Paz Rivera – DR202095   
- Rodrigo André Henríquez López – HL211477  

---

## 📋 Funcionalidades Implementadas (Fase 1)

✅ Registro e inicio de sesión para **Clientes**, **Empresas** y **Administradores**  
✅ Registro de solicitudes de empresas  
✅ Aprobación y rechazo de empresas por parte del administrador  
✅ Asignación de porcentaje de comisión a empresas aprobadas  
✅ Registro de clientes mayores de 18 años  
✅ Recuperación de contraseña según rol  
✅ Dashboard de administrador  
✅ Gestión de usuarios de empresa  
✅ Gestión CRUD de administradores  
✅ Redirección automática según rol después del login  

---

## 🧰 Tecnologías

- Laravel 12  
- Laravel Fortify
- Blade, TailwindCSS, Alpine.js  
- MySQL  
- Vite

---

## 🚀 Instalación

> **Requisitos previos**  
> - PHP ≥ 8.2  
> - Composer  
> - Node.js ≥ 16  
> - MySQL

1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/cuponera-sv.git
cd cuponera-sv
```
2. Configurar .env
```bash
cp .env.example .env
php artisan key:generate
```
3. Modificar .env
```bash
DB_DATABASE=cuponera
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
4. Instalar dependencias
```bash
composer install
npm install
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
## 📂 Estructura de carpetas destacadas

- `app/Http/Controllers` – Controladores agrupados por rol: Administrador, Empresa, Cliente  
- `app/Models` – Modelos con relaciones
- `app/Actions/Fortify` – Lógica personalizada para autenticación, registro y recuperación  
- `resources/views` – Vistas Blade separadas por tipo de usuario  
- `database/migrations` – Migraciones para todas las entidades del sistema  
- `database/seeders` – Seeders para roles y administrador por defecto

## 📎 Recursos adicionales

- [Tablero en Trello](https://trello.com/invite/b/681518e87a85c59e9083a154/ATTIcb7d39e2aac20be0c609fe718bc840810B6E3D70/proyecto-de-catedra-lis941) – Seguimiento del desarrollo










