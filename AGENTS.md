# AI assistant project context — Ironforge Gym

## Purpose and stack
Gym web application for IT 2001. Static SPA frontend uses HTML, CSS and JavaScript. Future REST backend must use PHP/FlightPHP, PDO and MySQL.

## Structure
- `frontend/index.html`: SPA entry point
- `frontend/js/router.js`: frontend routing
- `frontend/views/`: HTML views
- `frontend/css/`: styling
- `frontend/assets/`: images
- `backend/routes/`: future FlightPHP endpoints
- `backend/services/`: future business logic
- `backend/dao/`: future PDO database access
- `backend/middleware/`: future authentication, authorization and logging
- `backend/config/`: future config template; secrets must not be committed
- `backend/logs/`: runtime logs; never commit logs
- `docs/AI_LOG.md`: milestone-by-milestone AI usage notes

## Conventions and constraints
- Keep frontend and backend code separate.
- Preserve existing files and behavior unless the student explicitly approves changes.
- Keep HTML views in `frontend/views/` and JS in `frontend/js/`.
- Use services as the only layer that calls DAOs when backend is implemented.
- Do not commit credentials, API keys, JWT secrets, vendor files or runtime logs.
- Explain all generated code to the student before submission.

## Milestone 2 update

Database schema and sample data: database/iron_forge_gym.sql.
Seven entity DAOs: backend/dao.
Shared PDO connection: backend/config/Database.php.
Public template: config.example.php.
Private config.php must never be committed.

Use actual primary keys, prepared values and allowlisted
identifiers. PHP includes use __DIR__.
Services are the only future application layer allowed to
call DAOs; CLI tests are an exception.
Keep the existing frontend unchanged.
No FlightPHP routes/JWT are implemented yet.

Run php backend/tests/dao_test.php against a disposable,
configured MySQL database.
Naming: PascalCase entity Dao classes, camelCase methods,
snake_case database names.