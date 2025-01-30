# Dynamic Class Loader
In this project you are required to implement a dynamic class loader from class User. 
## Goals
The skills you will learn from this project include:

- PHP Namespaces
- Basic Composer
- Composer Autoloading

## Requirements
You are required to implement a dynamic class loader from class User.
- Configuration composer autoload with psr-4
- Implementation namespace in class User
- import vendor autoload and call namespace

### Configuration
```json
"autoload": {
 "psr-4": {
    "App\\": "src/"
    }   
}
```
### Implementation namespace
```php
namespace App\Controllers;
```
```bash
composer dump-autoload
```
### Import vendor autoload and call namespace
```php
require_once('./vendor/autoload.php');
use App\Controller\User;
```

This project will help you understand how to import and implement a dynamic class loader. 