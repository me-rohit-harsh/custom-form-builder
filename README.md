# Custom Form Builder

A modern, drag-and-drop form builder built with Laravel, TailwindCSS, Alpine.js, and SortableJS.

## Setup Steps

This application is ready to run out of the box with zero complex configuration. 

1. **Clone the repository:**
   ```bash
   git clone https://github.com/me-rohit-harsh/custom-form-builder.git
   cd custom-form-builder
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

<<<<<<< HEAD
3. **Install NPM dependencies and build assets:**
   ```bash
   npm install
   npm run dev
   ```

4. **Serve the application:**
=======
3. **Serve the application:**
>>>>>>> def8580 (fix gitignore and updated readme)
   ```bash
   php artisan serve
   ```
   *The app will be available at `http://localhost:8000/`. No database configuration or migrations are required for the UI assessment.*

---

## Technical Decisions & Rationale

### Drag & Drop Library: SortableJS
I chose **SortableJS** for handling the drag-and-drop interactions for the following reasons:
- **Lightweight & Native:** It uses the native HTML5 drag-and-drop API, meaning it doesn't require heavy dependencies (like jQuery UI) and performs exceptionally well on modern browsers.
- **Framework Agnostic:** It integrates seamlessly with our Alpine.js state management without causing virtual DOM conflicts.
- **Features:** It provides built-in support for multiple linked lists (dragging from the palette to the canvas) and clone modes out of the box, making it the perfect fit for a form builder palette.

### State Management: Alpine.js
Alpine.js was chosen because it provides the reactive nature of a framework like Vue or React, but directly within the Blade templates. This avoids the overhead of setting up a complex SPA architecture while still keeping the UI snappy and state-driven.

---

## Assumptions Made

1. **Backend API:** It is assumed that the form data will eventually be submitted to an external REST API endpoint. The form builder allows configuring a standard `POST URL` (submission URL).
2. **Database Persistence:** For the scope of this frontend UI assignment, saving the form layout persists locally via `localStorage`. Database persistence (saving the schema to a backend model) is mocked via console output to demonstrate the data structure.
3. **No Auth Required:** The form builder is open and accessible without user authentication for ease of review.

---

## Sample JSON Output

When the form is finalized and the "export schema" function is run, the application generates a structured JSON object representing the form. This is what the backend would receive to render the final form to end-users.

```json
{
  "title": "Contact Information Form",
  "submissionUrl": "https://api.example.com/v1/submissions",
  "settings": {
    "submitButtonText": "Submit Response",
    "submitButtonColor": "indigo",
    "customCss": ""
  },
  "fields": [
    {
      "id": "field_1718014567201_a1b2c3d4e",
      "type": "text",
      "label": "Full Name",
      "placeholder": "Enter your full name",
      "required": true,
      "cssClass": "mb-4"
    },
    {
      "id": "field_1718014589002_x9y8z7w6v",
      "type": "radio",
      "label": "Preferred Contact Method",
      "required": false,
      "options": [
        "Email",
        "Phone Call",
        "SMS"
      ]
    },
    {
      "id": "field_1718014601112_m5n6o7p8q",
      "type": "state_city",
      "label": "Location Information",
      "required": true
    }
  ]
}
```
