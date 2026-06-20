# humteachers

A small PHP web app that takes curriculum PDFs (chapters from a textbook) and uses the OpenAI Chat Completions API to generate teaching material for a chapter: a lesson plan, a worksheet, suggested activities, and a set of presentation slides.

## What it does

The basic flow is:

1. A teacher uploads a chapter PDF and tags it with grade, curriculum, subject, and chapter name. The file is stored as a BLOB in MySQL along with its metadata.
2. On the "Create Teaching Plan" page, the teacher picks grade / curriculum / subject / chapter from dropdowns and submits.
3. The frontend posts that selection (as JSON) to `api/v1/createstudyplan.php`.
4. The backend looks up the matching PDF, extracts its text with `smalot/pdfparser`, and sends that text plus a set of canned prompts to OpenAI (`gpt-3.5-turbo`).
5. It returns one OpenAI response per prompt. The browser renders each result in its own box with a "Copy" button.

The prompts themselves live in `promts.json` (note the spelling) and cover four outputs: `lesson_plan`, `worksheet`, `activities`, and `slides`.

There is no auth, no user accounts, and no persistence of generated plans. Everything is generated fresh on each request.

## Files / structure

Top-level pages and entry points:

- `index.php` - trivial landing page, just a link to the create-plan page.
- `createteachingplan.php` - the main UI. Dropdowns for grade/curriculum/subject/chapter (hard-coded in PHP), loads `scripts/studyplan.js` which does the AJAX call.
- `index_doc.php` - the upload/admin page. Pulls in the upload form, the upload handler, and a table listing uploaded documents.
- `upload_form.php` - HTML form for uploading a chapter PDF with its metadata.
- `upload.php` - handles the POST: reads the file, stores it and its metadata in the DB.
- `document_list.php` - renders a table of everything in `chapter_details`.

API endpoints:

- `api/v1/createstudyplan.php` - the real workhorse. Looks up the document, extracts text, loops over the prompts, calls OpenAI, returns a JSON blob of responses.
- `api/v1/getstudyplan.php` - returns all rows from `chapter_details` as JSON.

Backend helpers:

- `database_init.php` - MySQL connection (`initiate_database`) and thin query helpers (`db_query`, `db_fetch_array`). Also contains a `create_database()` function with the schema, though see the note below about it.
- `model.inc` - the data-access functions (insert document, fetch document, fetch by chapter, etc.). Raw SQL.
- `utils.php` - `pdf2text()` (wraps smalot/pdfparser), a tiny logger, and JSON/HTTP response helpers (`api_write_success_and_exit`, `api_write_error_and_exit`, `convert_json`).
- `includes/generate_open_api.php` - the `GenerateOpenApiFrameWork` class that builds the payload and makes the cURL call to OpenAI.
- `includes/api_includes.php` - include bundle for the API endpoints.
- `included_files.php` - include bundle for the page-level scripts.
- `test.php` - a `generateRandomValue()` helper used to prefill the upload form. It currently returns an empty string before any of its logic runs (early `return ""`), so it's effectively a no-op.

Frontend assets:

- `scripts/studyplan.js` - jQuery. Gathers the form values, POSTs them, and renders the OpenAI responses into the page.
- `styles/studyplan.css` - styling.
- `images/loader.gif` - spinner shown while generating.

Other:

- `promts.json` - the prompt templates.
- `composer.json` / `vendor/` - the only real dependency is `smalot/pdfparser`. `vendor/` (and `composer.phar`) is committed to the repo.
- `.vscode/launch.json` - Xdebug / built-in-server launch configs.

## Running it

Requirements:

- PHP with `mysqli` and `curl` extensions.
- MySQL.
- An OpenAI API key.
- Composer dependencies are already vendored in the repo, so you don't strictly need to run `composer install` unless you wipe `vendor/`.

Steps:

1. Create the database and tables. The app expects a database called `teacher_ai` with two tables, `chapter_details` and `chapter_document`. The SQL is in `database_init.php` inside `create_database()`, but heads up: that function is never actually called, and it overwrites its own `$sql` variable several times so only the last statement would run anyway. In practice you need to create the schema yourself. The tables it expects are roughly:
   - `chapter_details(id, grade, curriculum, subject, chapter, document)`
   - `chapter_document(id, name, type, size, content MEDIUMBLOB)`
2. Set the DB credentials. They are hard-coded in `database_init.php` as `localhost` / `root` / empty password / `teacher_ai`. Edit `initiate_database()` to match your setup.
3. Set your OpenAI API key. In `includes/generate_open_api.php` the `OPEN_API_AUTHORIZATION` constant is a placeholder (`Bearer YOUR_OPENAI_API_KEY`). Replace it with your real key, or wire it up to read from an environment variable instead of hard-coding it. As shipped it will not authenticate against OpenAI until you do this.
4. Serve the app. The simplest path is PHP's built-in server from the project root:
   ```
   php -S localhost:8000
   ```
   Then open `http://localhost:8000/index_doc.php` to upload a chapter PDF, and `http://localhost:8000/createteachingplan.php` to generate plans.

Usage notes:

- The dropdown values on `createteachingplan.php` are hard-coded to one grade (Grade 6), one curriculum (NCERT), and two subject/chapter pairs (Maths / Science). To get a useful result, the chapter you select needs to match a chapter you actually uploaded, since the API looks up the stored PDF by the exact grade/curriculum/subject/chapter strings.
- The frontend (`append_body_div` in `studyplan.js`) expects the response to contain all four keys (`lesson_plan`, `worksheet`, `activities`, `slides`), each with an OpenAI `choices[0].message.content`. If any are missing or OpenAI returns an error shape, the render will throw.

## Known rough edges

This is an early/prototype-stage project. Some things to be aware of before relying on it:

- **SQL injection.** Almost every query in `model.inc` (and `db_get_document_by_chapters`) interpolates user-supplied values directly into the SQL string with no escaping or prepared statements. Grade, curriculum, subject, chapter, and uploaded file metadata all flow straight into queries. This is exploitable and should be rewritten with parameterized queries (`mysqli` prepared statements) before any real deployment.
- **`max_tokens` is 10.** In `generate_open_api.php` the payload sets `max_tokens => 10`, which truncates every OpenAI response to a handful of tokens. So even when everything is wired up correctly, the generated lesson plans/worksheets will be cut off almost immediately. This needs to be raised for the output to be usable.
- **Schema setup is not automated.** `create_database()` is dead code (never called, and self-overwriting). You must create the DB and tables by hand.
- **Hard-coded config.** DB credentials live in source, and the OpenAI key is a placeholder constant in source. There is no `.env` or config file; you edit the PHP directly.
- **Windows-style include paths.** A couple of files use backslash paths (`vendor\autoload.php` in `utils.php`, `..\..\promts.json` in `createstudyplan.php`). These happen to resolve on Windows but are fragile on Linux/macOS and worth normalizing to forward slashes.
- **Prompt key typo.** `createstudyplan.php` checks for `"lessson_plan"` (three s's) when special-casing the lesson-plan prompt, but the key in `promts.json` is `lesson_plan`. So the Science / Bruner special-case prompts never actually fire; the generic prompt from the JSON is always used.
- **Naive token limiting.** When the extracted PDF text exceeds 4097 "words" it just keeps the first 4097-character chunk and drops the rest. There's no real chunking or summarization.
- **Leftover/dead code.** There's an unused `makeOpenAPIPostCall1()` with a hard-coded "world series" request, a `debugger;` statement left in the JS, commented-out test code, and `test.php`'s random-value generator short-circuits to an empty string.
- **Vendored dependencies.** `vendor/` and `composer.phar` are checked into the repo rather than installed via Composer.
- **No tests, no auth, no error handling to speak of.** The `test_*` functions are stubs, and API errors mostly return a generic 401 with `{"status":"error"}`.

