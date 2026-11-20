# AI Usage Log

## Milestone 1

### AI Tool Used
ChatGPT (OpenAI)

### Tasks Performed
- Reviewed Milestone 1 project requirements.
- Assisted with project documentation, including README, AGENTS.md and AI_LOG.md.
- Helped identify and fix broken CSS and JavaScript references.
- Assisted with responsive design and Hero slider issues.
- Helped correct demo Login and Register form behavior.
- Assisted with navigation links.

### Representative Prompts (Paraphrased)
1. "Fix the Hero images on desktop and mobile without changing the rest of the design."
2. "Remove broken library references and fix JavaScript or CSS loading errors."
3. "Prevent Login and Register forms from exposing passwords in the URL."
4. "Make both Upgrade Membership buttons navigate to the Our Plans section on the homepage."

### AI Errors and How They Were Fixed

**1. Broken CSS and JavaScript references**

- **Problem:** ChatGPT provided a project ZIP that still contained broken references to missing CSS and JavaScript libraries.
- **Detection:** During browser testing, Chrome Developer Tools showed 404 and MIME-type errors.
- **Fix:** The broken references were removed or replaced with working dependencies. The website was tested again.

**2. Incorrect jQuery filename**

- **Problem:** A jQuery 3.6.1 file was incorrectly named as version 3.3.1.
- **Detection:** The version in the file header did not match its filename.
- **Fix:** The filename and corresponding HTML reference were corrected.

**3. Hero image display problems**

- **Problem:** AI-generated changes caused the Hero images to appear black or display at inconsistent heights on mobile devices.
- **Detection:** The problems were noticed during visual testing in the browser and Chrome mobile device emulation.
- **Fix:** The image paths and CSS rules were corrected. Both Hero slides were adjusted to display consistently on mobile.

### Student Review

The project was reviewed through browser testing, including navigation, responsive layout, Login/Register forms and Hero image display.

The AI-generated suggestions were checked and revised when they caused errors. The student remains responsible for understanding the project code and explaining its functionality during the defense.

## Milestone 2

### AI Tool Used

ChatGPT / Codex (OpenAI)

### Tasks Performed

- Reviewed the database and DAO implementation against Milestone 2 requirements.
- Corrected primary-key handling and PHP include paths.
- Added sample database records and a configuration template.
- Added validation of writable database columns.
- Prepared CRUD integration tests and updated documentation.

### Representative Prompts

- "Keep the Milestone 1 frontend unchanged."
- "Explain BaseDao and guide me through testing with XAMPP."

### AI Errors and Corrections

**1. Incorrect assumptions about available tools**

The assistant initially suggested installation commands requiring
tools and permissions unavailable in the cloud environment.
The command errors exposed the issue, and validation was moved
to an available Docker environment.

**2. Invalid sample password hash**

A copied password hash did not match the documented demo password.
A password_verify check exposed the mismatch. The hash was replaced
with a newly generated hash and checked again.

### Validation

The DAO integration test was run locally using XAMPP against
the iron_forge_gym_v2 database.

All seven entities passed create, read, update, list and delete
checks. Additional query, input-validation and database-constraint
checks also passed.



## Milestone 3

### AI Tool Used
ChatGPT / Codex (OpenAI)

### Tasks Performed
- Reviewed the requirements PDF, Labs 04/05/06 and their supplied skeleton ZIPs.
- Reviewed the old project's milestone3 branch; adapted useful patterns to the completed Milestone 2 schema instead of copying incompatible code.
- Added seven entity services, validation/business rules, native-transaction DAO helpers, FlightPHP CRUD routes and centralized JSON errors.
- Added OpenAPI PHP attributes, local Swagger UI assets and Sarajevo weather/workout advice through Open-Meteo.
- Wrote and executed CLI, HTTP, documentation and concurrency checks; documented XAMPP setup.

### Representative Prompts (Paraphrased)
- "Do the necessary work, test it and return the files here; do not push anything."
- "Keep My Account/Logout navigation for when real login is introduced."

### AI Errors and Corrections

**1. An overly broad edit inserted an extra timezone statement**
The assistant's initial text replacement added the MySQL timezone statement both after the PDO connection and inside the missing-configuration error branch, where it was unreachable. Reading back Database.php exposed the misplaced statement. It was removed before testing; only the real connection initialization sets UTC.

**2. Wrong selector in the browser regression test**
The first browser script expected `.trainers-section`, but the existing Trainers view uses `.team-section`. The test timed out although the page was loaded. The assistant checked the actual HTML, fixed the selector and reran the browser checks successfully. The frontend source was not changed to satisfy the test.

**3. Incorrect assumption about the cloud dependency installer**
The first Composer install had neither the zip extension nor unzip available. After adding unzip, GitHub archive downloads were denied by the cloud policy. The assistant added Git to the temporary test image and used Composer's supported source installation with locked commit references over the allowed HTTPS Git route. TLS verification remained enabled; project code and the lockfile were not weakened to bypass verification.

### Validation and Limitations
The existing DAO tests, 50 service checks, 74 HTTP checks through both PHP's development server and Apache, and simultaneous last-seat/duplicate reservation checks passed against a real MySQL 8 database. OpenAPI generated 26 paths / 54 operations / 31 schemas; formal validation and 17 real response-schema comparisons passed. Swagger Try it out worked in Chromium and existing SPA routes/mobile menu remained functional.

Weather fixture tests verify normalization, workout advice, failure handling and logging. The live Open-Meteo request is blocked by the cloud's destination policy and is not claimed as passed. No fake weather data is used by the application.


