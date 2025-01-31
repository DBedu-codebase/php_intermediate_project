<?php

namespace App\Core;

use App\Core\App;
use App\Controllers\Book;
use App\Config\Config;

class Routes extends Config
{
     public function run()
     {
          $router = new App();
          $Book = new Book();
          // * Routes Books
          // ! GET
          $router->get('/api/v1/book', fn() => $Book->index());
          $router->get('/api/v1/book/:id', fn($id) => $Book->show($id));
          // ! POST
          $router->post('/api/v1/book', fn() => $Book->create());
          // ! UPDATE
          $router->post('/api/v1/book/update/:id', fn($id) => $Book->update($id));
          // ! DELETE
          $router->post('/api/v1/book/delete/:id', fn($id) => $Book->delete($id));
          $router->run();
     }
}
