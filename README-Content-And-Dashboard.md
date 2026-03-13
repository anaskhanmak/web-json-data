# Content & Admin Dashboard

This document explains how the JSON-driven content system and the admin dashboard work in this Laravel project.

---

## Overview

All homepage sections and their content (text, titles, buttons, lists, etc.) are driven by a **single JSON file**. You can turn sections on or off and edit all content from the **admin dashboard** without redeploying the app. Changes are saved back to the JSON file and appear on the live site immediately.

---

## Content File

### Location

- **Path:** `storage/app/content.json`
- The file is created automatically with default content if it does not exist.

### Structure

The JSON file is an object where each **top-level key** is a **section** (e.g. `hero`, `about`, `services`). Each section is an object with its own fields.

**Required field for every section:**

| Key       | Type    | Description                                                                 |
|-----------|---------|-----------------------------------------------------------------------------|
| `enabled` | boolean | `true` = section is visible on the website. `false` = section is hidden.   |

All other keys in a section are your content (titles, descriptions, buttons, lists, etc.). You can use any keys and structure you need.

### Example

```json
{
    "hero": {
        "enabled": true,
        "title": "Welcome to Our Website",
        "subtitle": "We build amazing products",
        "button_text": "Get Started"
    },
    "about": {
        "enabled": true,
        "title": "About Us",
        "description": "We are a creative company."
    },
    "services": {
        "enabled": false,
        "title": "Our Services",
        "items": ["Web Development", "Mobile Apps", "UI/UX Design"]
    }
}
```

### Supported value types

- **Strings** – Shown as a single-line or multi-line text field in the dashboard.
- **Arrays of strings** (e.g. `items: ["A", "B"]`) – Shown as a list of inputs; you can add/remove items (empty entries are removed on save).
- **Objects** (nested key-value) – Shown as a JSON textarea in the dashboard; edit as JSON and it is saved as structured data.

---

## Admin Dashboard

### Access

- **URL:** `/admin/dashboard`
- **Methods:**  
  - **GET** – View and edit all content.  
  - **POST** – Save changes (form submit).

### What it does

1. **Reads** the current content from `storage/app/content.json`.
2. **Displays** one block per section (one per top-level key in the JSON).
3. **For each section:**
   - A checkbox to **enable** or **disable** the section (`enabled`).
   - Editable fields for every other key in that section, based on type:
     - String → text input or textarea (textarea if long or multi-line).
     - List of strings → multiple text inputs (empty lines removed on save).
     - Object → one textarea with JSON.
4. **On save:**  
   - Validates input (lengths, types).  
   - Writes the updated structure back to `storage/app/content.json`.  
   - Clears the content cache so the website shows the new content on the next request.

### Dynamic behaviour

- The dashboard **does not hardcode** section names. It **loops over** whatever keys exist in the JSON file.
- If you **add a new section** in `content.json` (e.g. `"testimonials": { "enabled": true, "title": "...", "quotes": [] }`), that section will **automatically appear** on the dashboard with the right fields (checkbox + title + list of quotes, etc.).
- No code changes are required for new sections to be editable in the admin panel.

### UI

- Built with Tailwind CSS (uses the project’s existing styles).
- Success and validation error messages are shown at the top of the page.
- “View site” link in the nav opens the live homepage in a new tab.

---

## Frontend (Homepage)

- The **homepage** (`/`) loads content via the **ContentService** (which reads from `storage/app/content.json`, with caching).
- The **view** (`resources/views/frontend/pages/home.blade.php`) uses this data to render each section.
- Only sections with **`enabled: true`** should be output; the view is responsible for checking `enabled` and for rendering the fields you added (e.g. hero, about, services, or any new section you add).
- If you add a new section in the JSON and want it on the homepage, you need to add the corresponding HTML/Blade in `home.blade.php` (and pass the right part of the `$content` array). The dashboard will already allow editing that section.

---

## Caching

- **Frontend:** Content is cached for **1 hour** (3600 seconds) to reduce file reads. When you **save** from the dashboard, this cache is **cleared**, so the next page load uses the updated JSON. No redeploy is needed for changes to appear.
- **Dashboard:** Always reads **directly from the file** (no cache) so you always see and edit the latest saved content.

---

## Adding a New Section

1. **Edit** `storage/app/content.json` and add a new key, for example:

   ```json
   "testimonials": {
       "enabled": true,
       "title": "What People Say",
       "quotes": ["Quote one", "Quote two"]
   }
   ```

2. Open **`/admin/dashboard`**. The new **testimonials** block will appear with:
   - An “enabled” checkbox.
   - A “title” field.
   - A “quotes” list (multiple inputs).

3. Edit and save. The JSON file is updated and the content cache is cleared.

4. To **show this section on the homepage**, add the corresponding markup in `resources/views/frontend/pages/home.blade.php` and use the data from `$content['testimonials']` (and check `enabled`).

---

## Routes Summary

| Method | URL               | Purpose                          |
|--------|-------------------|----------------------------------|
| GET    | `/`               | Homepage (JSON-driven content)   |
| GET    | `/admin/dashboard`| Show dashboard form              |
| POST   | `/admin/dashboard`| Save content from form            |

---

## Files Involved

| File / area | Role |
|-------------|------|
| `storage/app/content.json` | Single source of truth for section content and `enabled` flags. |
| `app/Services/ContentService.php` | Reads/writes JSON, manages cache, provides default content. |
| `app/Http/Controllers/PageController.php` | Homepage: loads content and passes it to the view. |
| `app/Http/Controllers/Admin/DashboardController.php` | Dashboard: shows form from JSON, validates and saves posted content. |
| `resources/views/frontend/pages/home.blade.php` | Renders homepage sections using `$content`. |
| `resources/views/admin/dashboard.blade.php` | Renders the editable form (loop over all sections). |
| `resources/views/admin/layout.blade.php` | Admin layout (nav, messages, Tailwind). |

---

## Summary

- **Content** = `storage/app/content.json` (one file, any sections and keys).
- **Dashboard** = `/admin/dashboard` – edit all sections in a loop; new keys in JSON show up automatically.
- **Visibility** = each section’s `enabled` flag; frontend only shows sections where `enabled` is true.
- **Updates** = save from dashboard → file updated → cache cleared → changes live on the next request.

---

## Complete Explanation: ContentService, PageController, DashboardController

Below is a full breakdown of what each class does and how it works.

---

### 1. ContentService (`app/Services/ContentService.php`)

**Role:** This is the single place that reads and writes `storage/app/content.json`. The frontend uses it to get content (with cache); the dashboard uses it to read and save content.

#### Constants

- **`CACHE_KEY`** (`'website_content_json'`) – Key used in Laravel’s cache to store the parsed content. Same key is used to read and to clear cache.
- **`CONTENT_PATH`** (`'app/content.json'`) – Relative path of the file inside the `storage/` directory.

#### Methods

| Method | What it does |
|--------|----------------|
| **`getPath()`** | Returns the full path to the JSON file: `storage_path('app/content.json')` (e.g. `/path/to/project/storage/app/content.json`). Used wherever we need to read or write the file. |
| **`getContent()`** | **Used by the frontend (homepage).** Returns the content as a PHP array. First checks the cache: if the key `website_content_json` exists and is not expired, it returns that. Otherwise it calls `readFromFile()`, stores the result in cache for **3600 seconds (1 hour)**, and returns it. So the website does not read the file on every request. |
| **`readFromFile()`** | **Used by the dashboard and inside `getContent()`.** Reads the file from disk with **no cache**. If the file does not exist, returns `getDefaultContent()`. If the file exists, reads it, decodes JSON; if JSON is invalid or not an array, returns `getDefaultContent()`. Otherwise returns the decoded array. |
| **`saveContent(array $content)`** | **Used by the dashboard on save.** Takes the full content array, creates the directory if needed, writes the array to the file as pretty-printed JSON (with unescaped unicode/slashes), then calls `clearCache()` so the next frontend request gets fresh data. |
| **`clearCache()`** | Removes the key `website_content_json` from the cache. Called only from `saveContent()` so that after every save the site shows updated content. |
| **`getDefaultContent()`** | Returns a default structure (hero, about, services with `enabled`, titles, etc.). Used when the file is missing or when JSON decode fails, so the app never breaks. |
| **`ensureFileExists()`** | If the JSON file does not exist, calls `saveContent(getDefaultContent())` so the file is created with default data. Used when opening the dashboard or the homepage so the file is always there. |

**Flow in short:**

- **Homepage:** `getContent()` → cache or `readFromFile()` → array passed to view.
- **Dashboard (show form):** `readFromFile()` → array passed to view (no cache).
- **Dashboard (save):** Form data → controller builds array → `saveContent(array)` → file written → `clearCache()`.

---

### 2. PageController (`app/Http/Controllers/PageController.php`)

**Role:** Serves the **homepage** (`/`). It gets content from `ContentService` and passes it to the view so the page can render hero, about, services, etc.

#### Constructor

- **`private ContentService $content`** – Laravel injects `ContentService` here. The controller only talks to this service for content; it does not touch the file or cache directly.

#### Method: `home()`

1. **`$this->content->ensureFileExists()`** – Makes sure `storage/app/content.json` exists. If not, the service creates it with default content.
2. **`$content = $this->content->getContent()`** – Gets the full content array. This uses **cached** data when available (1-hour TTL), so the homepage is fast.
3. **`return view('frontend.pages.home', [...])`** – Renders the Blade view and passes:
   - **`content`** – The full array (all sections). The view uses this to show hero, about, services and to check `enabled`.
   - **`title`** – For the HTML `<title>` and meta (from hero title or fallback `'Welcome'`).
   - **`description`** – For meta description (from about description or empty string).

So: **PageController = “get content from ContentService and send it to the home view.”** It does not handle admin or saving; that is the dashboard’s job.

---

### 3. DashboardController (`app/Http/Controllers/Admin/DashboardController.php`)

**Role:** Handles **`/admin/dashboard`**. Two actions: **show the form** (GET) and **save the form** (POST). It reads content from `ContentService` (from file, no cache) and saves the posted data back through the same service.

#### Constructor

- **`private ContentService $contentService`** – Injected by Laravel. Used to read and save content.

#### Method: `index()` (GET `/admin/dashboard`)

1. **`$this->contentService->ensureFileExists()`** – Creates the JSON file with default content if it does not exist.
2. **`$content = $this->contentService->readFromFile()`** – Loads content **from the file only** (no cache), so the admin always sees the last saved state.
3. **`return view('admin.dashboard', ['content' => $content])`** – Renders the dashboard view and passes the full `$content` array. The view loops over `$content` and builds one block per section (hero, about, services, or any new key you add in JSON).

So: **index = “ensure file exists, read current content from file, show the edit form.”**

#### Method: `update(Request $request)` (POST `/admin/dashboard`)

This method takes the form data, converts it into the same structure as the JSON, validates it, then saves via `ContentService`.

1. **Read raw input**  
   - **`$raw = $request->input('content', [])`** – Form sends data as `content[hero][title]`, `content[hero][enabled]`, etc. So `content` is a nested array. If it’s not an array, redirect back with an error and old input.

2. **Build clean `$content` array**  
   - Loop over each section in `$raw`. For each section:
     - **`enabled`** – Convert to boolean with `filter_var(..., FILTER_VALIDATE_BOOLEAN)` so we always store `true`/`false`.
     - **Array values** (e.g. list of items) – Remove empty/null entries and re-index with `array_values(array_filter(...))`.
     - **String values** – If the string looks like JSON (starts with `[` or `{`), decode it and store the array/object; otherwise store the string. This allows the “JSON textarea” fields in the dashboard to work.
   - Result is a clean `$content` array in the same shape as the JSON file.

3. **Validate**  
   - **`$rules = $this->buildValidationRules($content)`** – Builds rules for every section/field (e.g. `hero.title` => `nullable|string|max:5000`, list fields => `nullable|array|max:20` and `*.nullable|string|max:500`).
   - If validation fails, redirect back to the dashboard with errors and `withInput()` so the form is repopulated.

4. **Save and redirect**  
   - **`$this->contentService->saveContent($content)`** – Writes `$content` to `storage/app/content.json` and clears the cache.
   - Redirect back to the dashboard with a success message.

So: **update = “read form → normalize (enabled, arrays, JSON strings) → validate → save via ContentService → redirect.”**

#### Method: `buildValidationRules(array $content)` (private)

- Loops over every section and every field (skips `enabled`).
- For each field it adds rules:
  - **List array** (numeric keys): `nullable|array|max:20` and `{$key}.*` => `nullable|string|max:500`.
  - **Associative array / object**: `nullable|array`.
  - **String**: `nullable|string|max:5000`.
- Returns the rules array for `Validator::make($content, $rules)`.

So: **validation is dynamic** – whatever sections and fields exist in the JSON (and thus in the form) get validated without hardcoding field names.

---

### How they work together

```
User visits /              → PageController::home()
                            → ContentService::getContent()  [cache or readFromFile]
                            → view('frontend.pages.home', ['content' => ...])

User visits /admin/dashboard → DashboardController::index()
                            → ContentService::readFromFile()  [no cache]
                            → view('admin.dashboard', ['content' => ...])

User saves form (POST)      → DashboardController::update($request)
                            → build $content from $request->input('content')
                            → validate $content
                            → ContentService::saveContent($content)
                            → file written, cache cleared
                            → redirect to dashboard with success
```

- **ContentService** = only place that reads/writes the file and manages cache.
- **PageController** = uses ContentService to get content (cached) and show the homepage.
- **DashboardController** = uses ContentService to show the latest file content and to save the form back to the same file; after save, cache is cleared so the homepage shows new content on next load.
