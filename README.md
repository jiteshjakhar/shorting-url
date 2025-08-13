# Laravel Short URL Assignment

This is a Laravel 11 project for a Short URL service as per the assignment requirements.  

---

## **Features**

- Multi-role user system: `SuperAdmin`, `Admin`, `Member`.
- Authentication with Laravel Breeze.
- SuperAdmin can invite Admins to create new companies.
- Admin can invite other Admins or Members within their own company.
- Short URL generation (Admin and Members can create URLs; only accessible via proper roles).
- Role-based access control.
- Bootstrap 5 UI for basic frontend design.

---

## **Requirements**

- PHP 8.2+
- Laravel 11
- MySQL
- Composer
- Node.js & npm

---

## **Setup Instructions**

1. Clone the repository:

```bash
git clone https://github.com/jiteshjakhar/shorting-url.git
cd shorting-url

---
#  **Instalation Instructions**

composer install

npm install
npm run dev

setup .env file and database authentication

php artisan migrate

php artisan db:seed --class=SuperAdminSeeder

php artisan serve

## Default super admin credentials 
id: superadmin@example.com
pw: 12345678

