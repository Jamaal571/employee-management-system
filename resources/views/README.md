# Employee Management System

A simple Employee Management System built with Laravel and MySQL as part of an internship skill assessment project.

## Features
- User authentication (login/register) via Laravel Breeze
- Full CRUD for Departments (create, view, edit, delete)
- Full CRUD for Employees (create, view, edit, delete)
- Employees are linked to Departments via a relationship
- Search employees by name
- Dashboard showing total employees and total departments

## Tech Stack
- **Backend:** Laravel 12
- **Database:** MySQL
- **Frontend:** Blade templates, Tailwind CSS
- **Auth:** Laravel Breeze

## Setup Instructions
1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and set your database credentials
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `npm install && npm run build`
7. Run `php artisan serve`
8. Visit `http://127.0.0.1:8000` in your browser

## Database Structure
- **departments**: id, name, timestamps
- **employees**: id, name, email, phone, position, salary, hire_date, department_id (foreign key), timestamps