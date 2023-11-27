# Laravel Project

This is a Laravel project with instructions on how to set it up locally.

## Prerequisites

Before you begin, make sure you have the following installed on your machine:

- [PHP](https://www.php.net/) (recommended version)
- [Composer](https://getcomposer.org/) (dependency manager for PHP)
- [Node.js](https://nodejs.org/) (for front-end dependencies)
- [npm](https://www.npmjs.com/) or [Yarn](https://yarnpkg.com/) (package managers for Node.js)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/KhaProMax/CarRentalRestFulAPI.git
2. **Install PHP dependencies with Composer:**
   ```bash
   composer install
3. **Running the Application:**
   ```bash
   php artisan serve

## Work with existing database

If you have database installed on your machine (ex: MySQL), please edit your .env file like this:
   ```dotenv
   DB_CONNECTION=your_database_connection
   DB_HOST=your_database_host
   DB_PORT=your_database_port
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```
Example:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=carrental
   DB_USERNAME=root
   DB_PASSWORD="root"
   ```

# API Testing with Postman

This repository contains a Postman collection and environment for testing the API.
- Dowload [Postman](https://www.postman.com/) to start testing the API.
  
Chuc ban mot ngay vui ve, cam on vi da den.
