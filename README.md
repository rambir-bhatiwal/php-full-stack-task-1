
README – Laravel 12 Full Stack Task
===================================

Project Setup Instructions
--------------------------

1. Installation

    git clone https://github.com/rambir-bhatiwal/php-full-stack-task-1
    cd laravel-task
    composer install
    cp .env.example .env
    php artisan key:generate

2. Environment Configuration

    - Create a new database and update your .env file:

      DB_DATABASE=your_db
      DB_USERNAME=your_user
      DB_PASSWORD=your_password

3. Migrations & Seeders

    php artisan migrate --seed

4. Run the Project

    php artisan serve

    Access your app at: http://localhost:8000


Authentication APIs
--------------------

| Endpoint        | Method | Description            |
|-----------------|--------|------------------------|
| /api/register   | POST   | User registration      |
| /api/login      | POST   | User login             |
| /api/user       | GET    | Get authenticated user |

- Use Bearer <token> in Authorization header for protected routes.
- Auth is managed via Laravel Sanctum.


Swagger API Docs
----------------

Swagger UI available at: http://localhost:8000/api/documentation

To update Swagger docs:

    php artisan l5-swagger:generate


Hierarchical Self-Referencing Table
-----------------------------------

- You can manage and view parent-child relationships in the categories table.
- A recursive function in the controller is used to display nested structures in Blade.

Example Output:

    - Ramesh  
      - Gaurav  
      - Shalu  
      - Deepu  
    - Amit   
    - Sham Lal  
    - Kapil 
    - Prem Chopra


Blade Views
-----------

- The frontend view is in resources/views/hierarchy.blade.php.
- Data is passed from controller using recursion for clean nesting.


WordPress Integration (Handled Separately)
------------------------------------------

- Custom Post Type: Book
- CRUD functionality implemented via WP Admin and custom templates.
- Advanced search by title, author, and description is also available in a separate WP theme file.


Folder Structure (Important)
----------------------------

    app/
    ├── Http/
    │   ├── Controllers/
    │   │   ├── AuthController.php
    │   │   └── HierarchyController.php
    │
    routes/
    ├── api.php     # API routes
    ├── web.php     # Web routes
    resources/
    ├── views/
    │   └── hierarchy.blade.php


To-Do Checklist
---------------

- [x] Register/Login API with Sanctum
- [x] Swagger documentation
- [x] Recursive category tree
- [x] WordPress CPT for Books with advanced search
