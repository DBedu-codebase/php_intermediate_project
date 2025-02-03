<?php

namespace App\Controllers\Todo;

use App\Core\Validation;
use App\Middleware\Auth;
use App\Model\TodoModel;
use Exception;
use PDOException;
use stdClass;

class Todo extends Validation
{
     private Auth $auth;
     private TodoModel $todoModel;
     public function __construct()
     {
          $this->auth = new Auth();
          $this->todoModel = new TodoModel();
     }

     // * GET
     public function getAll()
     {
          try {
               $this->auth->authenticate();
               $paramsQuery = [
                    'page' => filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1,
                    'limit' => filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT) ?: 10,
                    'orderBy' => in_array($_GET['orderBy'] ?? 'ASC', ['ASC', 'DESC']) ? $_GET['orderBy'] : 'ASC',
                    'status' => $_GET['status'] ?? ''
               ];
               $result = $this->todoModel->getAll($paramsQuery, $this->auth->authenticate());
               echo json_encode([
                    'message' => "Successfully Get All Todo",
                    'data' => [
                         'todo' => $result,
                         'payload' => $this->auth->authenticate()
                    ]
               ]);
          } catch (PDOException $e) {
               echo json_encode(['error' => 'Failed to get todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          } catch (Exception $e) {
               echo json_encode(['error' => 'Failed to get todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }

     public function getTodoById($id)
     {
          try {
               $result = $this->todoModel->getById($id);
               if (empty($result)) {
                    http_response_code(404);
                    echo json_encode([
                         'error' => 'Todo not found',
                    ]);
                    exit();
               }

               echo json_encode([
                    'message' => "Successfully Get Blog Based Id",
                    'data' => [
                         'blog' => $result
                    ]
               ]);
          } catch (PDOException $e) {
               echo json_encode(['error' => 'Failed to get todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          } catch (Exception $e) {
               echo json_encode(['error' => 'Failed to get todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }
     // * POST
     public function create()
     {
          try {
               $this->auth->authenticate();
               $input = json_decode(file_get_contents('php://input'), true);
               header("Content-Type: application/json");
               // * validation simple input
               $validationRules = [
                    'title' => 'required|string|min:3|max:50',
                    'description' => 'required|string|min:3|max:255',
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
               // * create blog post
               $result = $this->todoModel->create($input, $this->auth->authenticate());
               echo json_encode([
                    'message' => "Successfully Create Todo",
                    'data' => [
                         'todo' => $result
                    ]
               ]);
          } catch (PDOException $e) {
               echo json_encode(['error' => 'Failed to get todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          } catch (Exception $e) {
               echo json_encode(['error' => 'Failed to get todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }

     // * PUT
     public function update($id)
     {
          try {
               $this->auth->authenticate();
               $Todo = $this->todoModel;
               $getTodoId = $Todo->getById($id);
               if (empty($getTodoId)) {
                    http_response_code(404);
                    echo json_encode([
                         'error' => 'Todo not found',
                    ]);
                    exit();
               }
               $input = json_decode(file_get_contents('php://input'), true);
               header("Content-Type: application/json");
               // * validation simple input
               $validationRules = [
                    'title' => 'required|string|min:3|max:50',
                    'description' => 'required|string|min:3|max:255',
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
               //  * validate author
               $Todo->confirm_author($id, $this->auth->authenticate());
               // * create blog post
               $result = $Todo->update($id, $input, $this->auth->authenticate());
               echo json_encode([
                    'message' => "Successfully Update TodoList",
                    'data' => [
                         'todo' => $result
                    ]
               ]);
          } catch (PDOException $e) {
               echo json_encode(['error' => 'Failed to get todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          } catch (Exception $e) {
               echo json_encode(['error' => 'Failed to update todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }

     // * DELETE
     public function delete($id)
     {
          try {
               $this->auth->authenticate();
               $Todo = $this->todoModel;
               $result =  $Todo->getById($id);
               if (empty($result)) {
                    http_response_code(404);
                    echo json_encode([
                         'error' => 'Todo not found',
                    ]);
                    exit();
               }
               //  * validate author
               $Todo->confirm_author($id, $this->auth->authenticate());
               //* Delete blog post
               $Todo->delete($id);
               echo json_encode(['message' => 'Deleted successfully']);
          } catch (PDOException $e) {
               echo json_encode(['error' => 'Failed to delete todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          } catch (Exception $e) {
               echo json_encode(['error' => 'Failed to delete todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }
}
