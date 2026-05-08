# ASTU Clearance Management System

A web-based clearance and exit management system for Adama Science and Technology University. The system helps students submit clearance requests, departments review and approve requests, and administrators manage users, departments, and clearance records from one place.

## Live Deployment

Live site: https://clearance-management.gt.tc


## Overview

The ASTU Clearance Management System digitizes the student clearance process. Instead of moving manually between offices, a student can apply online, departments can review pending requests, and the final clearance status can be tracked through the system.

## Key Features

- Student registration and login
- Role-based dashboards for students, departments, and admins
- Student clearance request submission
- Department approval and rejection workflow
- Rejection comments for department decisions
- Admin department management
- Admin user creation and role assignment
- Clearance progress tracking
- Clearance certificate PDF download after full approval
- MySQL database integration
- XAMPP local development support
- InfinityFree deployment support

## Technology Stack

- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Local server: XAMPP
- Hosting target: InfinityFree

## Project Structure

```text
web-engineering-ASTU-clearance-management-system/
|-- backend/
|   |-- config/
|   |   |-- db.php
|   |   `-- hosting.example.php
|   |-- controllers/
|   |   |-- AdminController.php
|   |   |-- AuthController.php
|   |   |-- DepartmentController.php
|   |   `-- StudentController.php
|   |-- database/
|   |   |-- schema.sql
|   |   |-- infinityfree_schema.sql
|   |   `-- import_schema.php
|   |-- routes/
|   |   `-- api.php
|   `-- index.php
|-- frontend/
|   |-- admin/
|   |-- departments/
|   |-- student/
|   |-- Home.html
|   |-- Register.html
|   |-- login.html
|   `-- index.html
|-- .htaccess
|-- index.php
`-- README.md
```

## Local Setup With XAMPP

1. Copy the project folder into:

```text
C:\xampp\htdocs\
```

2. Start these services from XAMPP Control Panel:

```text
Apache
MySQL
```

3. Import the local database schema:

```bash
C:\xampp\php\php.exe backend\database\import_schema.php
```

Or import this file manually in phpMyAdmin:

```text
backend/database/schema.sql
```

4. Open the project in your browser:

```text
http://localhost/web-engineering-ASTU-clearance-management-system/
```

## Default Admin Account

```text
Email: admin@astu.edu
Password: admin123
```

Use this account to create departments and users.

## Database

Local database name:

```text
test_db
```

Main tables:

- `users`
- `departments`
- `clearance_requests`
- `approvals`
- `notifications`
- `logs`

## InfinityFree Deployment

1. Upload the project files to InfinityFree `htdocs`.

2. Create a MySQL database from the InfinityFree control panel.

3. Open InfinityFree phpMyAdmin and import:

```text
backend/database/infinityfree_schema.sql
```

4. Copy this file:

```text
backend/config/hosting.example.php
```

Rename the copy to:

```text
backend/config/hosting.php
```

5. Update `hosting.php` with your InfinityFree database details:

```php
<?php
$DB_HOST = "sqlXXX.infinityfree.com";
$DB_USER = "if0_XXXXXXXX";
$DB_PASS = "your_vpanel_password";
$DB_NAME = "if0_XXXXXXXX_database_name";
$DB_PORT = 3306;
```

6. Visit your live domain.

## Important Deployment Notes

- Upload files into `htdocs`, not inside an extra nested folder unless you want that folder in the URL.
- The root `index.php` redirects users to the frontend home page.
- The `.htaccess` file sets `index.php` and `index.html` as default directory files.
- InfinityFree database names are usually prefixed, for example `if0_12345678_database`.
- Do not use local XAMPP credentials like `root` on InfinityFree.

## API Entry Point

All frontend requests go through:

```text
backend/index.php
```

Example:

```text
backend/index.php?action=login
backend/index.php?action=register
backend/index.php?action=apply
backend/index.php?action=admin_departments
```

## Main User Roles

Student:

- Register and login
- Apply for clearance
- Track department approval status
- Download certificate after full approval

Department:

- View assigned clearance requests
- Approve requests
- Reject requests with comments

Admin:

- Create departments
- Create users
- View all clearance requests
- Manage the clearance workflow

## Author

Developed as a Web Engineering project for ASTU Clearance Management.

## License

This project is intended for academic and learning purposes.
