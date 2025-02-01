<?php

namespace App\Controllers;


use PDOException;
use Exception;
use Firebase\JWT\JWT;
use App\Core\Validation;
use App\Model\UserModel;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2), '.env');
$dotenv->load();

class User extends Validation
{
     private UserModel $userModel;

     public function __construct()
     {
          $this->userModel = new UserModel();
     }
     public  function register()
     {
          try {
          } catch (PDOException $e) {
               echo json_encode(['error' => 'Failed to register: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }
     public  function login()
     {
          try {
          } catch (Exception $e) {
               http_response_code(500);
               echo json_encode(['message' => 'Failed to generate token', 'error' => $e->getMessage()]);
          }
     }
}
