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


