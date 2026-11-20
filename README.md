# IronForge Gym

IronForge Gym is a responsive single-page web application (SPA) designed for gym management and fitness services. The project aims to provide an online platform where gym members can explore fitness classes, view trainer information, manage their profiles, and access booking features.

## Milestone 1 – Frontend Development

Milestone 1 includes the initial project structure, responsive frontend, client-side SPA navigation and a draft database Entity Relationship Diagram (ERD).

Implemented pages:

- Home
- Classes
- Trainers
- Login
- Register
- Dashboard
- Profile
- Bookings

Login, registration and account-related features currently operate as frontend demonstrations.

## Milestone 2 – Database and DAO Layer

Milestone 2 includes a relational database with sample data and a PHP PDO DAO layer.

A shared BaseDao provides reusable CRUD operations, while each database entity has its own DAO class.

## Milestone 3 – Services and REST API

Milestone 3 adds services for all seven entities, FlightPHP CRUD routes, centralized JSON errors, OpenAPI documentation with Swagger UI, and a Sarajevo weather endpoint using Open-Meteo.

The existing frontend remains unchanged.

## Technologies Used

- HTML5
- CSS3
- JavaScript
- Bootstrap
- jQuery
- Font Awesome
- PHP
- PDO
- MySQL / MariaDB
- FlightPHP REST API
- OpenAPI / swagger-php and Swagger UI

## Project Structure

- `frontend/` – Frontend application, including HTML views, CSS, JavaScript, and images.
- `frontend/index.html` – Main application entry point.
- `frontend/js/router.js` – Client-side routing and navigation.
- `frontend/views/` – Individual application pages.
- `backend/config/` – Database connection and configuration template.
- `backend/dao/` – BaseDao and entity DAO classes.
- `backend/tests/` – DAO, service, API, OpenAPI and weather tests.
- `backend/routes/` – FlightPHP API routes.
- `backend/services/` – Validation and business rules; the only application layer that calls DAOs.
- `backend/utils/` – Validation, exceptions, HTTP client and error logging.
- `backend/public/v1/docs/` – OpenAPI attributes and Swagger UI.
- `backend/middleware/` – Reserved for Milestone 4 middleware.
- `database/` – SQL schema and sample data.
- `docs/` – Project documentation and AI usage log.
- `dbschema.png` – Database Entity Relationship Diagram (ERD).
- `AGENTS.md` – AI coding assistant instructions.

## Database Entities and Relationships

The database contains seven entities:

- Users
- Categories
- Trainers
- Classes
- Memberships
- Bookings
- User memberships

Classes reference categories and trainers. Bookings connect users with classes, while user memberships connect users with membership plans.

The database uses primary keys, foreign keys, and unique email constraints.

The ERD is available in `dbschema.png`. The database schema and sample data are available in `database/iron_forge_gym.sql`.

## User Roles and Test Accounts

The application is designed to support two roles:

### User

- Browse fitness classes and trainers.
- Access a personal dashboard.
- Manage profile information and bookings.

### Admin

- Manage users, classes, trainers, memberships, and bookings.

Role-based access control will be implemented in a later milestone.

### Sample Accounts

The database includes fictional development accounts:

| Role | Email | Password |
| --- | --- | --- |
| Admin | admin@ironforge.example | password |
| User | member@ironforge.example | password |

Passwords are stored as hashes. These accounts are database samples and cannot yet be used for frontend login. They must not be used in production.

## Running the Project Locally

### Requirements

- PHP 8.2+ with PDO MySQL, cURL and OpenSSL enabled
- Composer; PHP zip extension or unzip/7-Zip for dependency installation
- MySQL or compatible MariaDB
- Visual Studio Code with Live Server for the frontend-only setup
- Modern web browser
- Internet connection for external API requests and externally hosted frontend libraries

XAMPP can be used to provide Apache and the database server. Apache must be configured to use PHP 8.2 or newer.

### Frontend Setup

1. Clone or download the repository.
2. Open the project folder in Visual Studio Code.
3. Navigate to `frontend/index.html`.
4. Right-click the file and select **Open with Live Server**.

The frontend should be accessed through a local HTTP server rather than opening the HTML file directly using `file://`.

### Database Setup

1. Start MySQL in XAMPP.
2. Open phpMyAdmin and create an empty database using `utf8mb4_general_ci`.
3. Select the database and import `database/iron_forge_gym.sql`.
4. Copy `backend/config/config.example.php` to `backend/config/config.php`.
5. Enter your local database name, host, port, username, and password.

The SQL import replaces existing project tables. Use an empty development database or back up existing data first. An existing Milestone 2 database does not need to be imported again.

The private `config.php` file is excluded from Git and must not be committed.

### DAO Testing

Run the following command from the project root:

```bash
php backend/tests/dao_test.php
```

For the configured Windows PHP installation, run in PowerShell:

```powershell
& "C:\php83-ts\php.exe" ".\backend\tests\dao_test.php"
```

Adjust the PHP executable path if your installation uses another location.

Expected final output:

```text
ALL DAO TESTS PASSED (7 entities)
```

The test checks CRUD operations, selected queries and joins, input validation, and database constraints. Temporary test records are rolled back after execution.

## Running the API and Swagger

Install Composer dependencies from the project root:

```bash
composer install --working-dir=backend
```

Never commit `vendor/`.

### XAMPP Apache

Place the project in `C:\xampp\htdocs\ironforgegym`, configure the database, and start Apache and MySQL in XAMPP.

Open:

- Frontend: http://localhost/ironforgegym/frontend/
- API: http://localhost/ironforgegym/backend/
- Swagger UI: http://localhost/ironforgegym/backend/public/v1/docs/
- OpenAPI JSON: http://localhost/ironforgegym/backend/public/v1/docs/swagger.php

The included `.htaccess` requires mod_rewrite and AllowOverride All. Swagger detects the installation path; its UI assets are included locally.

### Alternative PHP Development Server

From the project root:

```bash
php -S localhost:8000 server.php
```

With Windows PowerShell, replace `php` with `& "C:\php83-ts\php.exe"` if the required PHP version is not on PATH.

Open:

- Frontend: http://localhost:8000/frontend/
- API: http://localhost:8000/backend/
- Swagger UI: http://localhost:8000/backend/public/v1/docs/
- OpenAPI JSON: http://localhost:8000/backend/public/v1/docs/swagger.php

All seven resources support GET (list/item), POST, PUT, PATCH and DELETE:
`users`, `categories`, `trainers`, `classes`, `memberships`, `bookings`, `user-memberships`.

Send write bodies as `application/json`. POST returns 201; successful reads, updates and deletes return 200. Invalid input returns 400, missing records 404 and unexpected failures a generic 500. Error responses contain `status` and `error` fields.

PUT/PATCH update supplied fields. All timestamps use UTC. Booking ownership and the user assigned to a purchased membership cannot be changed through updates.


## External API Integration

`GET /weather/sarajevo` calls Open-Meteo for current Sarajevo temperature, precipitation, wind and weather conditions. It returns a normalized result with an indoor/outdoor workout suggestion, prepared for the future dashboard. Open-Meteo requires no API key for this non-commercial course use.

The request has a connection/total timeout, verifies TLS and handles provider/network/JSON failures. The web-server user must be able to write to `backend/logs/`.

Failures return a friendly JSON 503, log the reason in ignored `backend/logs/error.log`, and do not disable the rest of the API. `weather_timeout` can be set in private `config.php` (default 5 seconds).

Attribution: [Open-Meteo](https://open-meteo.com/).

## Additional Tests

Run from the project root using the configured development database:

```bash
php backend/tests/services_test.php
php backend/tests/api_test.php
php backend/tests/docs_test.php
php backend/tests/weather_test.php
php backend/tests/weather_test.php --live
```

The service test rolls its fixtures back. The HTTP test starts its own temporary development server and cleans up its records. Auto-increment counters may advance. Weather fixture tests are deterministic; `--live` separately verifies the real provider and fails if unavailable.



## Deployment

The application is currently intended to run locally.

A public deployment URL will be provided in a future milestone.

## Planned Features

- User registration and authentication.
- JWT and role-based access control.
- Request logging middleware.
- Frontend connected to the backend.
- Frontend MVC organization and additional validation.
- Public deployment.

## AI Assistance

AI coding assistants were used during development for guidance, debugging, and project documentation.

Details of AI-assisted development are recorded in `docs/AI_LOG.md`.