# IronForge Gym

IronForge Gym is a responsive single-page web application (SPA) designed for gym management and fitness services. The project aims to provide an online platform where gym members can explore fitness classes, view trainer information, manage their profiles, and access booking features.

The application is being developed as part of the Web Programming course.

## Milestone 1 – Frontend Development

Milestone 1 focuses on implementing the frontend interface, responsive design, navigation, and initial project structure.

### Implemented Pages

- Home
- Classes
- Trainers
- Login
- Register
- Dashboard
- Profile
- Bookings

The application uses client-side routing to navigate between pages without reloading the entire website.

Login, registration, and account-related features currently operate as frontend demonstrations. Full backend authentication and persistent data storage are planned for future milestones.

## Technologies Used

- HTML5
- CSS3
- JavaScript
- Bootstrap
- jQuery
- Font Awesome
- MySQL (planned)
- PHP (planned for backend development)
- REST API (planned)

## Project Structure

- `frontend/` – Frontend application, including HTML views, CSS, JavaScript, and images.
- `frontend/index.html` – Main application entry point.
- `frontend/js/router.js` – Client-side routing and navigation.
- `frontend/css/style.css` – Application styling.
- `frontend/views/` – Individual application pages.
- `frontend/assets/` – Images and other static resources.
- `backend/` – Initial structure for future backend development.
- `docs/` – Project documentation and AI usage log.
- `dbschema.png` – Database Entity Relationship Diagram (ERD).
- `AGENTS.md` – AI coding assistant instructions.

## Database Entities and Relationships

The database design is documented in the Entity Relationship Diagram (`dbschema.png`) located in the project root.

The ERD defines the planned database structure and relationships required to support gym members, fitness classes, trainers, and bookings.

Database implementation and MySQL integration are planned for future milestones.

## User Roles and Test Accounts

The application is designed to support the following roles:

### User

- Browse available fitness classes.
- View trainer profiles.
- Access a personal dashboard.
- Manage profile information.
- Access booking-related features.

### Admin

The administrator role is planned to support gym management operations, including managing users, classes, trainers, and bookings.

### Test Accounts

Milestone 1 contains frontend demonstrations of login and registration functionality.

Role-based backend authentication and dedicated test accounts for each role have not yet been implemented. Test credentials will be documented when the authentication system is completed.

## Running the Project Locally

### Requirements

- Visual Studio Code
- Live Server extension
- Modern web browser
- Internet connection for externally hosted frontend libraries

### Frontend Setup

1. Clone or download the repository.
2. Open the project folder in Visual Studio Code.
3. Navigate to `frontend/index.html`.
4. Right-click the file and select **Open with Live Server**.
5. The application will open in your browser.

The frontend should be accessed through a local HTTP server rather than opening the HTML file directly using `file://`.

### Database Setup

The database design is available in `dbschema.png`.

MySQL database import and backend configuration are not required to run the Milestone 1 frontend.

When database integration is implemented, this section will include instructions for importing the `.sql` file and creating the required backend configuration file.

## External API Integration

External API integration is planned for a future milestone.

The selected external API, its purpose, and the application feature it supports will be documented after implementation.

## Swagger API Documentation

Swagger documentation is not available in Milestone 1 because the REST API has not yet been implemented.

The Swagger documentation URL will be added in a future milestone.

## Deployment

The application is currently intended to run locally using Live Server.

A public deployment URL will be provided when the application is deployed in a future milestone.

## Planned Features

Future development will focus on:

- PHP backend and REST API implementation.
- MySQL database integration.
- User authentication and authorization.
- Role-based access control.
- Persistent user profiles and bookings.
- Gym class and trainer management.
- External API integration.
- Swagger API documentation.
- Application deployment.

## AI Assistance

AI coding assistants were used during development for guidance, debugging, and project documentation.

Details of AI-assisted development are recorded in `docs/AI_LOG.md`.
