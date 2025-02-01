<?php

namespace App\Model;

use App\Config\Config;
use PDO;

class UserModel extends Config
{
     private $table = 'users';

     public function getUniqueUser(string $username)
     {
          $PDO = $this->getPdo();
     }
     public function PostUniqueUser(string $username, string $password_hash)
     {
          $PDO = $this->getPdo();
     }
}
