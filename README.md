# Send Mail API

This project is a simple RESTful API for managing emails using PHP and PostgreSQL. It includes endpoints to create, list, show, and delete emails. The project follows the PSR-12 coding standard and uses a simple routing mechanism.

## Features

- Create Email
- List Emails
- Show Email by ID
- Delete Email
- Send Email on Creation

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/enjun06/46ccc13fd7a3065e4063b1d27d8a33d0.git
    ```

2. Navigate to the project directory:
    ```sh
    cd 46ccc13fd7a3065e4063b1d27d8a33d0
    ```

3. Install dependencies:
    ```sh
    composer install
    ```

4. Set up the database:
    - Create a PostgreSQL database.
    - Update the `.env` file with your database credentials.

5. Run the migration:
    ```sh
    php database/migrations/create_emails_table.php
    ```

6. Start the PHP built-in server:
    ```sh
    php -S localhost:8000 -t public
    ```

## API Endpoints

- **Healthy Check**: `GET /api`
- **List Emails**: `GET /api/mail`
- **Show Email by ID**: `GET /api/mail/{id}`
- **Create Email**: `POST /api/mail`
- **Delete Email**: `DELETE /api/mail/{id}`

## System Design

### Overview

The system is designed as a simple RESTful API using PHP and PostgreSQL. It follows a layered architecture with controllers, models, and a router.

### Components

1. **Controller**: Handles incoming HTTP requests and returns responses. Validates inputs and interacts with models.
2. **Model**: Represents the data and business logic. Uses Eloquent ORM to interact with the PostgreSQL database.
3. **Router**: Routes incoming requests to the appropriate controller actions based on the HTTP method and URI.
4. **Validator**: Validates incoming request data against defined rules using the `illuminate/validation` package.

### System Design Diagram

```plaintext
+-----------------+       +-----------------+       +-----------------+
|                 |       |                 |       |                 |
|    HTTP Client  +------>+     Router      +------>+    Controller   |
|                 |       |                 |       |                 |
+--------+--------+       +--------+--------+       +--------+--------+
         ^                         |                         |
         |                         v                         |
         |                 +-------+-------+                 |
         |                 |               |                 |
         |                 |    Validator  |                 |
         |                 |               |                 |
         |                 +-------+-------+                 |
         |                         |                         |
         |                         v                         |
         |                 +-------+-------+                 |
         |                 |               |                 |
         |                 |     Model     +<----------------+
         |                 |               |
         |                 +-------+-------+
         |                         |
         v                         v
+--------+--------+       +--------+--------+
|                 |       |                 |
|  PostgreSQL DB  |       |  Response (JSON)|
|                 |       |                 |
+-----------------+       +-----------------+
