# Espacio Treviso — Sistema de Gestión Interno

Sistema web interno para la administración y operación de Espacio Treviso. Desarrollado con Laravel 7, incluye gestión de empleados, clientes, facturación CFDI, operaciones contables y reportes.

> **Estado del proyecto:** En desarrollo activo. La base de autenticación está funcional; los módulos de negocio están en construcción.

---

## Tabla de contenidos

- [Stack tecnológico](#stack-tecnológico)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Módulos del sistema](#módulos-del-sistema)
- [Estructura del proyecto](#estructura-del-proyecto)
- [Base de datos](#base-de-datos)
- [Autenticación](#autenticación)
- [Rutas](#rutas)
- [Desarrollo frontend](#desarrollo-frontend)
- [Estado del desarrollo](#estado-del-desarrollo)

---

## Stack tecnológico

| Capa | Tecnología |
|---|---|
| Backend | PHP 7.4+ / Laravel 7 |
| Frontend | Blade + Tailwind CSS |
| Base de datos | MySQL |
| Assets | Laravel Mix + Webpack + Sass |
| HTTP Client | Axios |

---

## Requisitos

- PHP >= 7.2.5
- Composer
- Node.js >= 12 + NPM
- MySQL >= 5.7
- Extensiones PHP: `BCMath`, `Ctype`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`

---

## Instalación

```bash
# 1. Clonar el repositorio
git clone <url-del-repo>
cd espaciotreviso

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias Node
npm install

# 4. Copiar variables de entorno
cp .env.example .env

# 5. Generar clave de la aplicación
php artisan key:generate

# 6. Configurar la base de datos en .env (ver sección Configuración)

# 7. Ejecutar migraciones
php artisan migrate

# 8. Compilar assets
npm run dev
```

---

## Configuración

Editar el archivo `.env` con los valores correspondientes al entorno:

```env
APP_NAME="Espacio Treviso"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=espaciotreviso
DB_USERNAME=root
DB_PASSWORD=
```

---

## Módulos del sistema

| Módulo | Ruta | Estado |
|---|---|---|
| Autenticación | `/` `/login` | ✅ Funcional |
| Dashboard | `/dashboard` | 🔧 Placeholder |
| CFDI / Facturación | `/cfdi` | 🔲 En desarrollo |
| Operaciones | `/operations` | 🔲 En desarrollo |
| Contabilidad | `/accounting` | 🔲 En desarrollo |
| Reportes | `/reports` | 🔲 En desarrollo |
| Clientes | `/clients` | 🔲 En desarrollo |
| Personal | `/staff` | 🔲 En desarrollo |
| Notificaciones | `/notifications` | 🔲 En desarrollo |
| Administración | `/admin` | 🔲 En desarrollo |
| Sincronización | `/sync` | 🔲 En desarrollo |

---

## Estructura del proyecto

```
espaciotreviso/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php          # Login / Logout
│   │       ├── CfdiController.php          # Facturación CFDI
│   │       ├── ClientsController.php       # Gestión de clientes
│   │       ├── OperationsController.php    # Operaciones
│   │       ├── AccountingController.php    # Contabilidad
│   │       ├── ReportsController.php       # Reportes
│   │       ├── StaffController.php         # Personal
│   │       ├── NotificationsController.php # Notificaciones
│   │       ├── SyncController.php          # Sincronización
│   │       └── AdminController.php         # Administración
│   ├── UsuarioEmpleado.php                 # Modelo de usuario (autenticación)
│   ├── Empleado.php
│   ├── Cliente.php
│   ├── Xml.php
│   ├── HistorialXml.php
│   ├── DepositoCliente.php
│   ├── ReembolsoCliente.php
│   └── MetodoPago.php
├── config/
│   └── auth.php                            # Guard configurado para UsuarioEmpleado
├── database/
│   └── migrations/                         # Migraciones de todas las tablas
├── resources/
│   ├── views/
│   │   └── auth/
│   │       └── login.blade.php             # Vista de inicio de sesión
│   ├── js/app.js
│   └── sass/app.scss
└── routes/
    ├── web.php
    └── api.php
```

---

## Base de datos

El sistema utiliza un esquema con nomenclatura en español. Todas las tablas personalizadas tienen timestamps desactivados.

| Tabla | Modelo | Descripción |
|---|---|---|
| `usuarioempleado` | `UsuarioEmpleado` | Cuentas de acceso de empleados |
| `empleado` | `Empleado` | Datos maestros de empleados |
| `cliente` | `Cliente` | Datos maestros de clientes |
| `xml` | `Xml` | Almacenamiento de documentos XML (CFDI) |
| `historialxml` | `HistorialXml` | Historial y auditoría de XMLs |
| `depositoscliente` | `DepositoCliente` | Depósitos de clientes |
| `reembolsoscliente` | `ReembolsoCliente` | Reembolsos a clientes |
| `metodopago` | `MetodoPago` | Catálogo de métodos de pago |

---

## Autenticación

El sistema usa un guard de sesión personalizado basado en el modelo `UsuarioEmpleado` (tabla `usuarioempleado`), distinto al modelo `User` estándar de Laravel.

**Campos clave del modelo:**
- `NickUsuarioEmpleado` — nombre de usuario para login
- `PassUsuarioEmpleado` — contraseña (columna personalizada)

**Migración de contraseñas:** El sistema detecta contraseñas en texto plano y las convierte automáticamente a bcrypt en el primer inicio de sesión exitoso, asegurando compatibilidad con datos históricos.

---

## Rutas

```php
// Públicas
GET  /          → Formulario de login
POST /login     → Procesar autenticación
POST /logout    → Cerrar sesión

// Protegidas (requieren sesión activa)
GET  /dashboard → Panel principal

// Recursos (CRUD completo, en desarrollo)
/cfdi, /operations, /accounting, /reports,
/clients, /staff, /notifications, /admin, /sync
```

---

## Desarrollo frontend

```bash
# Compilar assets una vez
npm run dev

# Modo watch (recompila al guardar)
npm run watch

# Hot reload
npm run hot

# Build de producción
npm run prod
```

Los assets se compilan desde `resources/` hacia `public/js/` y `public/css/`.

---

## Estado del desarrollo

### Completado
- [x] Inicialización del proyecto Laravel 7
- [x] Migraciones de base de datos (9 tablas personalizadas)
- [x] Sistema de autenticación con modelo `UsuarioEmpleado`
- [x] Vista de login con Tailwind CSS (diseño responsivo)
- [x] Estructura de rutas para todos los módulos
- [x] Migración transparente de contraseñas (texto plano → bcrypt)

### En progreso / Pendiente
- [ ] Lógica de negocio en todos los controladores
- [ ] Vistas Blade para cada módulo
- [ ] Dashboard principal
- [ ] Módulo CFDI / Facturación
- [ ] Gestión de clientes y depósitos
- [ ] Reportes y contabilidad
- [ ] Sistema de notificaciones
- [ ] Sincronización de datos
- [ ] Panel de administración
- [ ] Autenticación API (tokens)

---

## Licencia

Uso interno — Espacio Treviso. Todos los derechos reservados.
