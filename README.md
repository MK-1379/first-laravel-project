# First Laravel Project – API REST de usuarios y eventos

API REST hecha con **Laravel 12** para el módulo de Desarrollo Web en Entorno Servidor (DWES) de 2º de DAW. Gestiona usuarios, sus direcciones, eventos y tipos de evento, y sirve para practicar las tres relaciones principales de Eloquent.

## Relaciones

| Relación | Modelos | Cómo se implementa |
| --- | --- | --- |
| Uno a uno (1:1) | `User` – `Address` | `hasOne` / `belongsTo`, clave foránea `user_id` en `addresses` |
| Muchos a muchos (N:M) | `User` – `Event` | `belongsToMany` en ambos modelos, tabla pivote `event_user` con una nota por reserva |
| Uno a muchos (1:N) | `EventType` – `Event` | `hasMany` / `belongsTo`, clave foránea `event_type_id` en `events` |

## Tecnologías

- PHP 8.2+
- Laravel 12
- MySQL / MariaDB (XAMPP)
- Laravel Sanctum
- Insomnia / Postman para probar la API

## Instalación

```bash
git clone https://github.com/MK-1379/first-laravel-project.git
cd first-laravel-project
composer install
cp .env.example .env
php artisan key:generate
```

Configura la base de datos en el `.env` (ajusta el puerto si tu MySQL no usa el 3306):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_dwes202
DB_USERNAME=root
DB_PASSWORD=
```

Crea la base de datos vacía `laravel_dwes202` y ejecuta:

```bash
php artisan migrate
php artisan serve
```

La API queda disponible en `http://localhost:8000/api`.

## Endpoints

Todas las peticiones deben llevar la cabecera `Accept: application/json`.

### Usuarios

| Método | Ruta | Descripción |
| --- | --- | --- |
| POST | `/api/register` | Registra un usuario (`name`, `email`, `password`, `c_password`) |
| GET | `/api/user/{user}` | Muestra un usuario |
| GET | `/api/user/{user}/address` | Muestra la dirección de un usuario |
| GET | `/api/user/{user}/events` | Lista los eventos reservados por un usuario |
| POST | `/api/users/{user}/events/{event}/book` | Reserva un evento para un usuario (`note` opcional) |

### Direcciones

| Método | Ruta | Descripción |
| --- | --- | --- |
| POST | `/api/address` | Crea la dirección de un usuario (`email`, `country`, `zipcode`) |
| GET | `/api/addresses` | Lista todas las direcciones |
| GET | `/api/address/{address}` | Muestra una dirección |
| GET | `/api/address/{address}/user` | Muestra el usuario de una dirección |

### Eventos

| Método | Ruta | Descripción |
| --- | --- | --- |
| POST | `/api/event` | Crea un evento (`event_name`, `event_detail`, `event_type_id`) |
| GET | `/api/events` | Lista todos los eventos |
| GET | `/api/event/{event}` | Muestra un evento |
| POST | `/api/event/{event}` | Elimina un evento |
| GET | `/api/event/{event}/users` | Lista los usuarios apuntados a un evento |

### Tipos de evento

| Método | Ruta | Descripción |
| --- | --- | --- |
| POST | `/api/type` | Crea un tipo de evento (`description`) |
| GET | `/api/type/{type}` | Lista los eventos de un tipo |

## Ejemplo de uso

Crear un tipo de evento y después un evento de ese tipo:

```http
POST /api/type
Content-Type: application/json

{ "description": "Conferencia" }
```

```http
POST /api/event
Content-Type: application/json

{ "event_name": "Hackaton", "event_detail": "Evento de prueba", "event_type_id": 1 }
```

Todas las respuestas siguen el formato:

```json
{
    "message": "Event Created",
    "data": { "...": "..." }
}
```

Si la validación falla, la API responde con un `400` y los errores de cada campo.

## Estructura principal

```
app/
├── Http/Controllers/
│   ├── UserController.php
│   ├── AddressController.php
│   ├── EventController.php
│   └── EventTypeController.php
└── Models/
    ├── User.php
    ├── Address.php
    ├── Event.php
    └── EventType.php
database/migrations/
routes/api.php
```

## Autor

Mario Díaz González – 2º DAW, CSC Jesuitas Logroño
[GitHub](https://github.com/MK-1379) · [Portfolio](https://mk-1379.github.io)
