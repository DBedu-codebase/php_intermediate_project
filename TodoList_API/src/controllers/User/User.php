<?php

namespace App\Controllers\User;


use PDOException;
use Exception;
use Firebase\JWT\JWT;
use App\Core\Validation;
use App\Model\UserModel;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 3), '.env');
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
               $user = $this->userModel;
               $input = json_decode(file_get_contents('php://input'), true);
               header("Content-Type: application/json");
               // * validation simple input
               $validationRules = [
                    'email' => 'required|email',
                    'name' => 'required|string|min:3|max:50',
                    'password' => 'required|password|min:8|max:255',
               ];
               foreach ($validationRules as $key => $rule) {
                    $this->addRule($key, $rule);
               }

               $errors = $this->validate($input);
               if (!empty($errors)) {
                    http_response_code(400);
                    echo json_encode(['errors' => $errors]);
                    exit();
               }
               // * check email and username must be unique
               $result = $user->getUniqueUser($input['email'], $input['name']);
               if (!empty($result)) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Email or name already exists']);
                    exit();
               }
               // * create hash password
               $password = password_hash($input['password'], PASSWORD_DEFAULT);
               echo $user->PostUniqueUser($input['email'], $input['name'], $password);
          } catch (PDOException $e) {
               //throw $th;
               echo json_encode(['error' => 'Failed to create blog post: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }
     public  function login()
     {
          try {
               $user = $this->userModel;
               $input = json_decode(file_get_contents('php://input'), true);
               header("Content-Type: application/json");
               // * validation simple input
               // * validation simple input
               $validationRules = [
                    'email' => 'required|email',
                    'password' => 'required',
               ];
               foreach ($validationRules as $key => $rule) {
                    $this->addRule($key, $rule);
               }

               $errors = $this->validate($input);
               if (!empty($errors)) {
                    http_response_code(400);
                    echo json_encode(['errors' => $errors]);
                    exit();
               }
               // * check email and password from db

               $result = $user->getUniqueUserEmail($input['email']);
               if (!$result) {
                    http_response_code(401);
                    echo json_encode(['message' => 'Email or password incorrect']);
                    exit();
               }
               // * validate password with hash password from db
               if (!password_verify($input['password'], $result['password'])) {
                    http_response_code(401);
                    echo json_encode(['message' => 'Email or password incorrect']);
                    exit();
               }

               // * generate jwt token
               $expiration_time = time() + 900;
               $payload = [
                    'id' => $result['user_id'],
                    'email' => $result['email'],
                    'exp' => $expiration_time
               ];

               if (!$_SERVER['ACCESS_TOKEN_SECRET']) {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to generate token', 'error' => 'ACCESS_TOKEN_SECRET is not set']);
                    exit();
               }

               $access_token = JWT::encode($payload, $_SERVER['ACCESS_TOKEN_SECRET'], 'HS256');

               echo json_encode([
                    'message' => 'Login successfully',
                    'data' => [
                         'access_token' => $access_token,
                         'expiry' => date(DATE_ATOM, $expiration_time)
                    ]
               ]);
          } catch (Exception $e) {
               http_response_code(500);
               echo json_encode(['message' => 'Failed to generate token', 'error' => $e->getMessage()]);
          }
     }
}
