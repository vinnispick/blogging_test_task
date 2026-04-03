# Blog Engine MVP

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-777bb4.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

A high-performance, lightweight blog engine built with pure PHP 8.1+ and Smarty. This project demonstrates a custom **Action-Domain-Responder (ADR)** architecture without the use of modern frameworks, focusing on SOLID principles and clean code.

---

## 🚀 Key Features

- **Main Page**: Interactive grouped view showing each category with its 3 latest articles.
- **Category Page**: 
  - **Pagination**: Navigate through article lists with adjustable page limits.
  - **Multi-level Sorting**: Persistent sorting interface for Date, View Count, and Alphabetical order with priority hierarchy.
- **Article Page**: High-readability content display with a "Similar Articles" recommendation engine.
- **Architecture**:
  - Custom **Dependency Injection Container**.
  - Robust **Router** for clean URLs.
  - **Action-Domain-Responder** pattern for clear separation of concerns.
- **Developer Tools**: High-fidelity CLI Seeder and Migration system.
- **Performance**: Optimized SQL queries with proper indexing and minimal load times.

---

## 🛠 Tech Stack

- **Backend**: PHP 8.1+ (Constructor promotion, Readonly properties, Strict types)
- **Frontend**: Smarty 4 Template Engine, Vanilla CSS, Sass/SCSS
- **Persistence**: MySQL 8.0+ (PDO with Prepared Statements)
- **Orchestration**: Docker & Docker Compose
- **DevOps**: Makefile for automated workflows

---

## 📂 Project Structure

```text
├── bin/                # CLI Scripts (Seed, Migrate)
├── config/             # Application configuration
├── migrations/         # SQL Migration files
├── public/             # Entry point & static assets
│   └── static/         # CSS, JS, Images
├── src/                # Core Logic (App Namespace)
│   ├── Application/    # DTOs & Application Services
│   ├── Core/           # DI Container, Router & Utils
│   ├── Domain/         # Entities, Repo Interfaces, Business Logic
│   ├── Infrastructure/ # Persistence (PDO implementations)
│   └── Presentation/   # HTTP Actions & Responders
├── templates/          # Smarty .tpl files
└── .obsidian_vault/    # Project documentation & rules
```

---

## ⚙️ Deployment

### Prerequisites

- PHP 8.1+
- Composer
- Docker & Docker Compose (optional)
- MySQL 8.0

### Local Setup (Manual)

1. **Install Dependencies**:
   ```bash
   make setup
   ```
2. **Configure Environment**:
   Copy `.env.example` to `.env` and update your database credentials.
3. **Run Migrations**:
   ```bash
   make migrate
   ```
4. **Seed Data**:
   ```bash
   make seed
   ```
5. **Start Server**:
   ```bash
   make serve
   ```
   Visit `http://localhost:8000`

### Docker Setup (Recommended)

1. **Start Containers**:
   ```bash
   make docker-up
   ```
2. **Run Migrations & Seed**:
   ```bash
   make migrate
   make docker-seed
   ```
   The application will be available at `http://localhost:8080`.

---

## 🔒 Security & Standards

- **SQL Injection**: Exclusively uses PDO Prepared Statements.
- **XSS Prevention**: Strict output escaping at the Smarty Template layer.
- **Strict Typing**: All files use `declare(strict_types=1);`.
- **Standards**: Follows **PSR-12** coding style.

---

## 📜 Documentation

Detailed documentation is available in the `.obsidian_vault/` directory:
- [Architecture Manifesto](.obsidian_vault/Rules/Architecture_Manifesto.md)
- [Database Schema](.obsidian_vault/Docs/Database_Schema.md)
- [Business Context](.obsidian_vault/Context/Business_Context.md)
- [Security Manifesto](.obsidian_vault/Rules/Secutiry_Manifesto.md)

---

## License

This project is open-source and available under the [MIT License](LICENSE).
