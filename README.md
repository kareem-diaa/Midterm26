# Secure Online Library Management System

## Project Abstract
The Secure Online Library Management System is a robust, role-based web application built with Laravel and styled with Tailwind CSS. Developed for the "Web and Security Technologies" midterm exam, this system strictly adheres to the Model-View-Controller (MVC) architectural pattern. The core objective of the project is to provide a seamless borrowing engine while guaranteeing enterprise-grade protection against common web vulnerabilities. 

## Technology Stack
* **Framework:** Laravel 11.x
* **Language:** PHP 8.2+
* **Frontend:** Tailwind CSS & Blade Templates
* **Authentication:** Laravel Breeze (Starter Kit)
* **Database:** MySQL / MariaDB
* **Asset Manager:** Vite

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

## Project Structure (MVC Highlights)
* **Controllers:** `app/Http/Controllers/` contains logical handlers (e.g., `BookController.php`, `BorrowController.php`).
* **Middleware:** `app/Http/Middleware/CheckRole.php` handles dynamic role verification.
* **Requests:** `app/Http/Requests/` houses `FormRequest` classes for strictly validated data entry.
* **Models:** `app/Models/` defines Eloquent relationships and `$fillable` protection.
* **Views:** `resources/views/` contains Blade templates structured by resource (Admin, Books, Borrows).
* **Migrations:** `database/migrations/` defines the database schema including foreign key constraints and defaulting logic.

---

## Database Schema
The system architecture relies on three primary entities:
* **Users:** Manages authentication and Role-Based Access Control (`role` enum).
* **Books:** Stores the library catalogue. Tracks global inventory via the `copies` integer.
* **Borrows:** A pivot/transactional table capturing the relationship between a `User` and a `Book`, specifically used for tracking successful borrow events and ensuring referential integrity via cascading deletes.

---

## Key Security Workflows

### Transactional Borrowing Logic
To prevent race conditions and inventory discrepancies, the borrowing process follows a strict atomic workflow:
1. **Transaction Initialization:** Opens a secure database transaction.
2. **Pessimistic Locking:** Executes `lockForUpdate()` on the target book record, preventing other processes from modifying the stock simultaneously.
3. **Inventory Validation:** Checks if `copies > 0`.
4. **Member-Bound Record Creation:** Inserts a borrowing record strictly tied to the `auth()->id()`.
5. **Atomic Decrement:** Reduces the copy count directly on the database level.
6. **Commit:** Finalizes changes only if all previous steps succeed.

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
   *Note: Ensure your `.env` file reflects your local database connection details (e.g., MySQL). **Crucially, make sure to create an empty database (e.g., `midterm_db`) in your MySQL manager (like phpMyAdmin) and update the `DB_DATABASE` variable in the `.env` file before running the next step.***

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
