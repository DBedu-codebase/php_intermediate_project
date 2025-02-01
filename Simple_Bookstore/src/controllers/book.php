<?php

namespace App\Controllers;

use PDOException;
use Exception;
use App\Core\Validation;
use App\Model\Book as BookModel;
use App\Core\Controller;

class Book extends Validation
{
     private BookModel $bookModel;
     private Controller $controller;
     public function __construct()
     {
          $this->bookModel = new BookModel();
          $this->controller = new Controller();
     }
     public function index()
     {
          $this->controller->render('index', ['books' => $this->bookModel->getAll()]);
     }
     public function show($id)
     {
          try {
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function create()
     {
          try {
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          } catch (Exception $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function update($id)
     {
          try {
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          } catch (Exception $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function delete($id)
     {
          try {
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function deleteAll()
     {
          try {
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function searchAndFilterByType()
     {
          try {
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          } catch (Exception $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
}
