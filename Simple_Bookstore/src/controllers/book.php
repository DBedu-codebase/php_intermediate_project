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
               $validationRules = [
                    'name' => 'required|string|min:3',
                    'brand' => 'required|string|min:3',
                    'price' => 'required|number|min:1'
               ];

               foreach ($validationRules as $key => $rule) {
                    $this->addRule($key, $rule);
               }

               $error = $this->validate($data);
               if (!empty($error)) {
                    $this->controller->render('index', [
                         'books' => $this->bookModel->getAll(),
                         'error' => $error
                    ]);
               }
               $this->bookModel->create($data);
               $this->controller->redirect('/api/v1/book', $error);
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          } catch (Exception $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function update($id)
     {
          try {
               $book = $this->bookModel->getById($id);
               if (empty($book)) throw new Exception('Book not found');
               $data = $_POST;
               $validationRules = [
                    'name' => 'required|string|min:3',
                    'brand' => 'required|string|min:3',
                    'price' => 'required|number|min:1'
               ];

               foreach ($validationRules as $key => $rule) {
                    $this->addRule($key, $rule);
               }

               $error = $this->validate($data);
               if (!empty($error)) {
                    $this->controller->render('update', [
                         'book' => $this->bookModel->getById($id),
                         'error' => $error
                    ]);
               }
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
               $book = $this->bookModel->getById($id);
               if (empty($book)) throw new Exception('Book not found');
               $this->bookModel->delete($id);
               $this->controller->redirect('/api/v1/book');
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function deleteAll()
     {
          try {
               $this->bookModel->deleteAll();
               $this->controller->redirect('/api/v1/book');
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
     public function searchAndFilterByType()
     {
          try {
               $postData = [
                    'simple-search' => $_GET['simple-search'] ?? '',
                    'price' => $_GET['price'] ?? 'low'
               ];
               $books = $this->bookModel->searchAndFilter($postData);
               $this->controller->render('index', [
                    'books' => $books,
                    'searchTerm' => $postData['simple-search'],
                    'priceOrder' => $postData['price']
               ]);
          } catch (PDOException $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          } catch (Exception $e) {
               $this->controller->render('error', ['error' => $e->getMessage()]);
          }
     }
}
