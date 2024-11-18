# WEBD_Project
This project is a PHP-based content management system (CMS) site with full CRUD functionalities. The project includes user authentication, service, requests, image uploads, and administrative controls.

## Features
- User authentication and authorization system with admin privileges
- Service management (CRUD operations)
  - Create, read, update and delete services
  - Set service titles, descriptions, estimates and types
- Request management
  - Users can create service requests
  - Upload and resize images for requests
  - Comment system on requests
  - Sort and search functionality
- User management (Admin only)
  - View all users
  - Edit user details
  - Delete users

## Tech Stack

- PHP 7+
- MySQL/MariaDB
- HTML/CSS
- JavaScript
- PDO for database operations
- [`ImageResize`](functions/ImageResize.php) class for image processing

## Installation

1. Configure database settings in [connect.php](connect.php)
2. Import database schema (not included in source)
3. Configure admin credentials in [authenticate.php](authenticate.php)
4. Ensure write permissions for `uploads/` directory

## Usage

- Register a new user account
- Login with email and password 
- Create service requests
- Upload images with requests
- Comment on requests
- Admin users can manage services and users

## Security Features

- Password hashing
- Input sanitization
- PDO prepared statements
- Session-based authentication
- Admin-only restricted areas