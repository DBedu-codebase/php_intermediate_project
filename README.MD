## PHP Intermediate Project-Based Learning: Project Documentation

This document serves as a starting guide for the PHP Intermediate project-based learning, outlining the project's structure and key components.  This project focuses on building a web application using a structured approach, incorporating best practices and design patterns.

### Project Overview

This project demonstrates intermediate PHP concepts, including database interaction, routing, middleware, and a structured file organization. The project's architecture emphasizes maintainability, scalability, and code reusability.

### Folder Structure

The project utilizes the following folder structure:

```
src/
├── config/
│   └── Config.php      # Database connection configuration
├── controllers/
│   └── [ControllerName].php # Handles application logic and interacts with models
├── views/
│   └── [ViewName].php    # Renders views and displays data
├── core/
│   ├── App.php           # Core application logic, routing, and request handling
│   ├── Routes.php        # Handles URL routing
│   └── Validation.php    # Utility functions for data validation
├── middleware/
│   └── auth.php  # Handles authentication and authorization
├── models/
│   └── [ModelName].php    # Represents database tables and handles data access
```

### Component Breakdown

**1. `config/`**

*   **`Config.php`:** This file contains the database connection configuration, including credentials (hostname, username, password, database name) from `.env files`.  It establishes the connection to the database using PDO (PHP Data Objects).
 ```php
 class Config
{
     private $host;
     private $user;
     private $password;
     private $dbname;
     private $pdo;

     public function __construct()
     {
          $this->host = $_SERVER['DB_HOST'];
          $this->user = $_SERVER['DB_USER'];
          $this->password = $_SERVER['DB_PASSWORD'];
          $this->dbname = $_SERVER['DB_NAME'];

          try {
               $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
               $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch (PDOException $e) {
               die("Connection failed: " . $e->getMessage());
          }
     }

     public function getPdo()
     {
          return $this->pdo;
     }
}
```

**2. `Controllers/`**

*   **`[ControllerName].php`:** Controllers handle the application's logic. They receive requests, interact with models to fetch or manipulate data, and then render views (or return data in other formats like JSON).  Each controller typically handles a specific part of the application (e.g., User management, Product management).

    ```php
    <?php
    require_once 'Models/User.php'; // Example: Include the User model

    class UserController {
        public function index() {
            $userModel = new User();
            $users = $userModel->getAllUsers(); // Get all users from the database
            // ... process data and render view ...
        }

        public function create() {
            // ... handle user creation logic ...
        }
    }
    ?>
    ```

**3. `Core/`**

*   **`App.php`:** This is the core of the application. It initializes the necessary components, handles routing, dispatches requests to the appropriate controllers, and manages the overall application flow.
*   **`Routes.php`:**  Handles URL routing. It maps incoming URLs to specific controller actions.  This allows for clean and user-friendly URLs.
*   **`Validation.php`:** Contains utility functions for validating user input. This helps ensure data integrity and prevents security vulnerabilities.

**4. `Middleware/`**

*   **`auth.php`:** Implements authentication and authorization logic.  It checks if a user is logged in and has the necessary permissions to access certain resources using JWT. Middleware runs before a request reaches the controller, allowing you to intercept and process it.
 ```php
 <?php
    class Auth
{
     private $headers;
     // Constructor to initialize headers
     public function __construct()
     {
          // Retrieve all HTTP request headers
          $this->headers = getallheaders();
     }
     // Method to authenticate the request
     public function authenticate()
     {
          try {
               // Check if the Authorization header is set
               // Extract the token from the Authorization header
               // Decode the JWT token using the secret key
          } catch (\Throwable $th) {
               // Catch any exceptions and respond with 500 Internal Server Error
               http_response_code(500);
               echo json_encode(['message' => 'Failed to authenticate: ' . $th->getMessage()]);
               exit();
          }
     }
}
?>
```

**5. `Models/`**

*   **`[ModelName].php`:** Models represent database tables and provide an interface for interacting with the data. They encapsulate database queries, making the code more organized and maintainable.

```php
<?php

namespace App\Model;
use App\Config\Config;
use PDO;

class UserModel extends Config
{
     private $table = 'user';

     public function getAllUsers() {
          $stmt = $this->db->query("SELECT * FROM {$this->table}");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     // ... other methods for user management (create, update, delete) ...
}
```
**6. `views/`**

*   **`[viewsName].php`:** Views are responsible for rendering the application's user interface. They receive data from controllers and generate HTML output. Views should be simple and only contain presentation logic.

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page</title>
    <link rel="icon" href="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <section class="grid place-items-center h-screen bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center">
                <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-blue-600 dark:text-blue-500">404</h1>
                <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">Something's missing.</p>
                <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">Sorry, we can't find that page. You'll find lots to explore on the home page. </p>
                <a href="/api/v1/book" class="inline-flex text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-900 my-4">Back to Login Page</a>
            </div>
        </div>
    </section>
</body>

</html>
```
### Getting Started

1.  **Set up your development environment:** Ensure you have PHP and a web server (like Laragon or XAMPP) installed.
2.  **Create Database Setup:** in `file template.sql`, you need to run one by one on the database schema to create the database structure.
3.  **Rename .env.sample to .env:** add the configuration based on your environment and add your JWT Secret with `php -r "echo bin2hex(random_bytes(32));"`.
4.  **Start Server:** Run the server using `php -S localhost:9000` or `composer run serve`.
5.  **Build your application:**
    
    The Project already setup, you can focus on the third part of project.
	*   **Create controllers:** Develop controllers to handle requests, interact with models, and manage the application's logic.
	*   **Design models:** Create models to represent your data entities and provide an interface to interact with the data.
	*   **Implement authentication:** Use middleware to handle authentication and authorization.

This documentation provides a basic overview of the project structure. As you progress, you'll add more features and refine the code. Remember to follow coding best practices and write clean, well-documented code.  Good luck with your project!
