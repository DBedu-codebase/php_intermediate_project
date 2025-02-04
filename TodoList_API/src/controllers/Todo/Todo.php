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
                         'page' => $paramsQuery['page'],
                         'limit' => $paramsQuery['limit'],
                         'total' => count($result)
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

               // * create todo post
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

               $input = json_decode(file_get_contents('php://input'), true);
               header("Content-Type: application/json");
               // * validation simple input

               //  * validate author

               // * create todo post

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
               //  * validate author
               //* Delete blog post
          } catch (PDOException $e) {
               echo json_encode(['error' => 'Failed to delete todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          } catch (Exception $e) {
               echo json_encode(['error' => 'Failed to delete todo: ' . $e->getMessage()], JSON_PRETTY_PRINT);
          }
     }
}
