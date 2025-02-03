<?php

namespace App\Core;

use App\Core\App;
use App\Controllers\Todo\Todo;
use App\Controllers\User\User;
use App\Config\Config;



class Routes extends Config
{
     public function run()
     {
          $router = new App();
          $User = new User();
          $Todo = new Todo();
          // * Routes Authentication 
          $router->post('/api/v1/auth/register', fn() => $User->register());
          $router->post('/api/v1/auth/login', fn() => $User->login());
          // * Routes Todo
          $router->get('/api/v1/todos', fn() => $Todo->getAll());
          $router->get('/api/v1/todos/:id', fn($id) => $Todo->getTodoById($id));
          $router->post('/api/v1/todos', fn() => $Todo->create());
          $router->put('/api/v1/todos/:id', fn($id) => $Todo->update($id));
          $router->delete('/api/v1/todos/:id', fn($id) => $Todo->delete($id));
          $router->run();
     }
}
