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
               $book = $this->bookModel->getById($id);
               $this->controller->render('update', ['book' => $book]);
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function create()
     {
          try {
               $data = $_POST;
               $this->validate($data, [
                    'title' => ['required', 'string'],
                    'author' => ['required', 'string'],
                    'price' => ['required', 'number']
               ]);
               $this->bookModel->create($data);
               $this->controller->redirect('book');
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          } catch (Exception $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function update($id)
     {
          try {
               $data = $_POST;
               $this->validate($data, [
                    'title' => ['required', 'string'],
                    'author' => ['required', 'string'],
                    'price' => ['required', 'number']
               ]);
               $this->bookModel->update($id, $data);
               $this->controller->redirect('/api/v1/book');
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          } catch (Exception $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function delete($id)
     {
          try {
               $this->bookModel->delete($id);
               $this->controller->redirect('/api/v1/book');
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
}
