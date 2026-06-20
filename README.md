# HumTeachers

> **Turn any curriculum PDF into ready-to-teach lesson plans, worksheets, and class slides — in seconds.**

![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![OpenAI](https://img.shields.io/badge/OpenAI-412991?logo=openai&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=white)
![REST API](https://img.shields.io/badge/REST-API-009688?logo=fastapi&logoColor=white)
![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)
![Made for Teachers](https://img.shields.io/badge/Made%20for-Teachers-ff6f61)

---

**HumTeachers** is an AI-powered teaching assistant that gives every educator back their evenings. Upload a chapter PDF, pick a grade and subject, and HumTeachers reads the curriculum and instantly generates a full teaching kit — lesson plan, printable worksheet, recommended videos, and presentation slides — powered by the OpenAI API. It is EdTech built around one promise: **less prep, more teaching.**

## ✨ Features

- **📄 PDF curriculum ingestion** — Upload any chapter PDF and HumTeachers extracts the text automatically with a built-in parser, no copy-paste required.
- **🧠 AI lesson plan generation** — Produces detailed, classroom-ready 45-minute lesson plans tailored to the selected grade, subject, and chapter.
- **📝 Instant worksheets** — Generates printable worksheets designed to surface exactly which students have grasped each learning objective.
- **🎬 Curated activity suggestions** — Recommends relevant, informative videos teachers can drop straight into the classroom.
- **📊 Presentation slides** — Outputs clean, student-facing slide decks ready to paste into any presentation tool.
- **🎓 Pedagogy-aware prompting** — Adapts its approach to proven teaching frameworks like the **5E Instructional Model** and **Bruner's Discovery Learning**, depending on the subject.
- **🔌 REST API** — A clean versioned `v1` API lets you create and retrieve teaching plans programmatically.
- **🗂️ Document library** — Every uploaded chapter is organized by grade, curriculum, subject, and chapter for fast reuse.

## 🛠️ Tech Stack

| Layer | Technology |
| --- | --- |
| **Backend** | PHP |
| **AI Engine** | OpenAI Chat Completions API (`gpt-3.5-turbo`) |
| **Database** | MySQL |
| **PDF Parsing** | [smalot/pdfparser](https://github.com/smalot/pdfparser) |
| **Dependencies** | Composer |
| **Frontend** | HTML, CSS, JavaScript |

## 🚀 Getting Started

### Prerequisites

- PHP 7.4+ with the `mysqli` and `curl` extensions
- MySQL
- [Composer](https://getcomposer.org/)
- An [OpenAI API key](https://platform.openai.com/)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/rahulcgon/humteachers.git
   cd humteachers
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure your OpenAI API key**
   Set your key in `includes/generate_open_api.php` so requests authenticate against the OpenAI API.

4. **Set up the database**
   Create a MySQL database named `teacher_ai`, then initialize the schema:
   ```bash
   php database_init.php
   ```

5. **Run the app**
   ```bash
   php -S localhost:8000
   ```
   Then open [http://localhost:8000](http://localhost:8000).

## 📡 API / Usage

HumTeachers exposes a simple, versioned REST API.

### Create a teaching plan

Generate a complete teaching kit for a chapter.

```http
POST /api/v1/createstudyplan.php
Content-Type: application/json
```

```json
{
  "grade": "6",
  "curriculum": "CBSE",
  "subject": "Science",
  "chapter": "1"
}
```

**Response**

```json
{
  "status": "success",
  "data": {
    "lesson_plan": { "...": "AI-generated lesson plan" },
    "worksheet":   { "...": "AI-generated worksheet" },
    "activities":  { "...": "recommended videos" },
    "slides":      { "...": "slide-by-slide deck" }
  },
  "status_code": 200
}
```

### List uploaded documents

Retrieve every chapter in the library.

```http
GET /api/v1/getstudyplan.php
```

```json
{
  "status": "success",
  "message": "All documents",
  "data": [
    { "grade": "6", "curriculum": "CBSE", "subject": "Science", "chapter": "1" }
  ],
  "status_code": 200
}
```

### Upload a curriculum PDF

Send a `multipart/form-data` POST to `upload.php` with the chapter PDF plus `grade`, `curriculum`, `subject`, and `chapter` fields. HumTeachers parses the PDF and stores it in the document library, ready for plan generation.

## 🗂️ Project Structure

```
humteachers/
├── api/
│   └── v1/
│       ├── createstudyplan.php   # Generate a full teaching kit
│       └── getstudyplan.php      # List documents
├── includes/
│   ├── api_includes.php          # Shared API bootstrap
│   └── generate_open_api.php     # OpenAI integration layer
├── scripts/
│   └── studyplan.js              # Frontend logic
├── styles/
│   └── studyplan.css             # Frontend styling
├── createteachingplan.php        # Teaching-plan UI
├── document_list.php             # Document library view
├── upload.php / upload_form.php  # PDF upload
├── database_init.php             # Schema setup
├── model.inc                     # Data access layer
├── utils.php                     # PDF parsing & API helpers
├── promts.json                   # AI prompt templates
└── composer.json                 # Dependencies
```

## 🤝 Contributing

Contributions are welcome! Open an issue to discuss an idea, or submit a pull request — every improvement helps teachers spend more time with their students.

---

<p align="center"><strong>HumTeachers</strong> — because great teaching shouldn't start with hours of prep. 🍎</p>

