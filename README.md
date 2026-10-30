# IronForge Gym

IronForge Gym is a responsive single-page web application (SPA) designed for gym management and fitness services. The project aims to provide an online platform where gym members can explore fitness classes, view trainer information, manage their profiles, and access booking features.

## Milestone 2 – Database and DAO Layer

Milestone 2 includes a relational database with sample data and a PHP PDO DAO layer.

A shared BaseDao provides reusable CRUD operations, while each database entity has its own DAO class.

The frontend is not yet connected to the database. Backend authentication and frontend integration are planned for later milestones.

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
- FlightPHP REST API (planned)

## Project Structure

- `frontend/` – Frontend application, including HTML views, CSS, JavaScript, and images.
- `frontend/index.html` – Main application entry point.
- `frontend/js/router.js` – Client-side routing and navigation.
- `frontend/views/` – Individual application pages.
- `backend/config/` – Database connection and configuration template.
- `backend/dao/` – BaseDao and entity DAO classes.
- `backend/tests/` – DAO integration test.
- `backend/routes/`, `backend/services/`, `backend/middleware/` – Directories for later backend development.
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

- PHP 8.1+ with PDO MySQL enabled
- MySQL or compatible MariaDB
- Visual Studio Code with Live Server
- Modern web browser
- Internet connection for externally hosted frontend libraries

XAMPP can be used to provide PHP and the database server.

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

The SQL import replaces existing project tables. Use an empty development database or back up existing data first.

The private `config.php` file is excluded from Git and must not be committed.

### DAO Testing

Run the following command from the project root:

    php backend/tests/dao_test.php

For XAMPP on Windows, run in PowerShell:

    & "C:\xampp\php\php.exe" ".\backend\tests\dao_test.php"

Expected final output:

    ALL DAO TESTS PASSED (7 entities)

The test checks CRUD operations, selected queries and joins, input validation, and database constraints. Temporary test records are rolled back after execution.

## External API Integration

External API integration is planned for Milestone 3.

The proposed feature is Sarajevo weather information through Open-Meteo, displayed on the dashboard to help members plan outdoor activities.

## Swagger API Documentation

Swagger documentation is not yet available because the REST API has not been implemented.

The documentation URL will be added when the API is completed.

## Deployment

The application is currently intended to run locally.

A public deployment URL will be provided in a future milestone.

## Planned Features

- FlightPHP REST API and service layer.
- OpenAPI documentation with Swagger.
- External API integration.
- User registration and authentication.
- JWT and role-based access control.
- Request logging and error handling.
- Frontend connected to the backend.
- Frontend MVC organization and additional validation.
- Public deployment.

## AI Assistance

AI coding assistants were used during development for guidance, debugging, and project documentation.

Details of AI-assisted development are recorded in `docs/AI_LOG.md`.