# Ironforge Gym

Static single-page frontend for a gym application, prepared for the IT 2001 Web Programming project.

## Milestone 1

Frontend: `frontend/index.html`, `frontend/js/router.js`, `frontend/css/style.css`, `frontend/views/` and `frontend/assets/`.

Existing views: Home, Login, Register, Dashboard, Classes, Trainers, Profile, Bookings.

Backend: folder skeleton only; REST API, MySQL integration, and authentication are planned for later milestones.

## Run locally

Serve the `frontend/` directory with a local HTTP server (e.g. VS Code Live Server) and open its `index.html`. Do not open with `file://`, because SPA view loading may require HTTP.

## ERD

See `dbschema.png` in the project root. Verify that the diagram includes at least five entities and their relationships before submission.

## Planned features and roles

Gym class discovery, trainer profiles, bookings, user profiles, and a dashboard. User/admin permissions and external API integration are to be specified and implemented in later milestones.

## Pending for later milestones

Database import/config instructions, test accounts, Swagger URL, external API details, and deployed URL will be added when implemented.

## Frontend libraries (Milestone 1)

Open `frontend/index.html` with VS Code Live Server. Bootstrap and jQuery are local; Font Awesome 4.7 and Owl Carousel 2.3.4 load from Cloudflare cdnjs and therefore require internet access. The original HTML references to unused/missing template plugins were removed to avoid 404 errors. SPA navigation remains in `frontend/js/router.js`.

Before submission, verify desktop/mobile layout and DevTools Console/Network. External API, backend, authentication and deployment are for later milestones.
