# Secure Online Library Management System

## Project Abstract
The Secure Online Library Management System is a robust, role-based web application built with Laravel and styled with Tailwind CSS. Developed for the "Web and Security Technologies" midterm exam, this system strictly adheres to the Model-View-Controller (MVC) architectural pattern. The core objective of the project is to provide a seamless borrowing engine while guaranteeing enterprise-grade protection against common web vulnerabilities. 

---

## Core Features
* **Role-Based Access Control (RBAC):** Distinct interfaces and operational privileges for Admins, Librarians, and general Members.
* **Dynamic Book Catalogue:** Full CRUD operations managed exclusively by authorized staff.
* **Transactional Borrowing Engine:** Members can securely check out books from the catalogue, automatically updating active inventory.
* **Account Dashboards:** Members have a dedicated dashboard to track their active borrowing status and history.
* **Staff Member Management:** Administrative tools to monitor registered users and escalate privileges by creating new Librarian accounts.

---

## Security Architecture
Security is the foundational pillar of this application. Below is a matrix of the implemented vulnerability mitigations:

* **Role-Based Access Control (RBAC):** Implemented a custom `CheckRole` middleware mapped strictly in `web.php` alongside UI-level `auth()->user()->hasRole()` Blade directives. Operations are securely gated at both the presentation and routing layers.
* **Concurrency & Race Condition Prevention:** The borrowing engine utilizes pessimistic locking (`lockForUpdate()`) enclosed within `DB::transaction()`. This guarantees that high-volume concurrent checkout requests cannot compromise the system's integrity or force the inventory `copies` integer below zero.
* **Insecure Direct Object Reference (IDOR) Mitigation:** All transactional records strictly bind to `auth()->user()`. A user cannot inject arbitrary IDs to borrow books on behalf of others, nor can they view the browsing history of other members. 
* **Mass Assignment Prevention:** The `$guarded` property is deliberately avoided. Every Eloquent Model (`User`, `Book`, `Borrow`) strictly declares allowed input fields via the `$fillable` array.
* **SQL Injection (SQLi) Prevention:** The system exclusively utilizes Laravel's Eloquent ORM and Query Builder, leveraging PHP data objects (PDO) and prepared statements.
* **Cross-Site Scripting (XSS) Prevention:** The entire presentation layer relies on Blade templating. All dynamic database outputs are wrapped in `{{ }}` directives for automatic `htmlspecialchars()` sanitization.
* **Cross-Site Request Forgery (CSRF) Protection:** Strict `@csrf` token enforcement on all state-changing HTML forms (`POST`, `PUT`, `DELETE`).
* **Input Validation:** Backend execution relies entirely on the injection of strict `FormRequest` classes (`StoreBookRequest`, `UpdateBookRequest`, etc.).

---

## Installation & Setup

Follow these steps to deploy the system locally:

1. **Clone the repository and enter the directory:**
   ```bash
   git clone https://github.com/kareem-diaa/Midterm26.git
   cd Midterm26
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install and compile frontend assets:**
   ```bash
   npm install
   npm run build
   ```

4. **Configure your environment variables:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Ensure your `.env` file reflects your local database connection details (e.g., MySQL).*

5. **Run Database Migrations and Seeders:**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Serve the Application:**
   ```bash
   php artisan serve
   ```

---

## Default Credentials
The database seeder automatically provisions the following test accounts. All passwords are set to `password`.

| Role | Email Address | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@library.com` | `password` |
| **Librarian** | `librarian@library.com` | `password` |
| **Member** | `member@library.com` | `password` |

---

## Author & Acknowledgements
* **Author:** Kareem Diaa
* **Professor:** Dr. Soliman Sarhan
* **Course:** CET232 Web and Security Technologies
* **Project:** Midterm 26 - Secure Online Library System

This project was developed as part of a practical examination, focusing heavily on modern security engineering and secure coding patterns in the Laravel ecosystem.

---
*Designed & engineered for robust web security.*
