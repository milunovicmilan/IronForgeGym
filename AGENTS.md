# AI assistant project context — IronForge Gym

## Purpose and stack
Gym management SPA
Milestone 1: static HTML/CSS/JS frontend. 
Milestone 2: MySQL/MariaDB and PHP PDO DAOs. 
Milestone 3: FlightPHP services/routes, PHP 8 OpenAPI attributes, Swagger UI and Open-Meteo weather. PHP 8.2+ is required. 

JWT, role middleware, My Account/Logout navigation, request logging and frontend integration are Milestone 4.

## Structure
- `frontend/`: existing SPA; `js/router.js` handles hash routing; `views/` contains HTML views.
- `backend/config/Database.php`: shared native PDO connection (utf8mb4, UTC); `config.example.php`: public template; `config.php`: ignored private settings.
- `backend/dao/`: shared CRUD and entity SQL, including row locks for reservations/memberships.
- `backend/services/`: seven entity services, reusable BaseService, and WeatherService.
- `backend/routes/`: presentation only; Flight reads requests and returns JSON.
- `backend/utils/`: strict validation, HTTP exceptions, JSON body reader, HTTP client and error logger.
- `backend/public/v1/docs/`: OpenAPI attributes and local Swagger UI resources/licenses.
- `backend/tests/`: CLI DAO, service, HTTP, docs, weather and concurrency tests.
- `backend/middleware/`: reserved for Milestone 4.
- `backend/logs/`: ignored runtime errors; not committed.
- `database/iron_forge_gym.sql`: Milestone 2 schema/sample data, unchanged in Milestone 3.
- `server.php`: PHP development router; `.htaccess` files support Apache/XAMPP.

## Architecture and conventions
- Keep frontend HTML/CSS/JS separate from PHP API code. Preserve existing frontend behavior.
- Only services call DAOs in application code. Tests may call DAOs directly. SQL and transaction/row-lock implementation stay in DAOs.
- Routes contain no business rules or local try/catch. Central error handling produces JSON; never expose SQL, stack traces or private paths.
- Use real snake_case primary keys (e.g. user_id), bound PDO values and allowlisted identifiers. Classes use PascalCase with Dao/Service suffixes; methods use camelCase.
- Validate before writes, hash passwords in UserService, and remove hashes from every user response. Do not add login/JWT behavior prematurely.
- A class row is locked while checking/creating/reactivating bookings or reducing capacity. A user row is locked while checking overlapping memberships. Cancellation preserves the booking record.
- API timestamps and MySQL session time zone are UTC. PUT/PATCH accept partial changes. Purchased memberships cannot be transferred; bookings cannot be moved to another class/user.
- Use the fixed HTTPS Open-Meteo endpoint, bounded timeouts and verified TLS. Provider failures must be logged and returned as friendly 503s; never substitute fixture data in production code.
- Composer declarations/lockfile are committed. Private config, vendor dependencies, log files and secrets are ignored. Never copy the original old project's credentials.
- Preserve milestone1/milestone2 history. No Git push, PR creation, merge or external messages without the student's explicit authorization.

## Verification and documentation
Run the tests listed in README against a disposable development DB. Never import SQL over user data without permission: it replaces project tables. API tests clean their rows; DAO/service tests roll back. Concurrency tests need Apache or another multi-worker server. Keep mock/fixture weather checks distinct from real provider verification.

Update README and docs/AI_LOG.md for each milestone. Record actual errors, fixes and test results.