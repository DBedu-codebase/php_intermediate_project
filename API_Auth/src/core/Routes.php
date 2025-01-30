<?php

namespace App\Core;

use App\Core\App;
use App\Controllers\User;
use App\Config\Config;

class Routes extends Config
{
     public function run()
     {
          $router = new App();
          $User = new User();
          // * Routes Authentication 
          $router->post('/api/v1/auth/register', fn() => $User->register());
          $router->post('/api/v1/auth/login', fn() => $User->login());
          $router->run();
     }
}
