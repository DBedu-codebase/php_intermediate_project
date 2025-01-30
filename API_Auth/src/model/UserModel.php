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
          $sql = "SELECT * FROM {$this->table} WHERE username = :username";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':username' => $username,
          ]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          return $result;
     }
     public function PostUniqueUser(string $username, string $password_hash)
     {
          $PDO = $this->getPdo();
          $sql = "INSERT INTO {$this->table} (username,password) VALUES (:username,:password)";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':username' => $username,
               ':password' => $password_hash,
          ]);
          return json_encode([
               'message' => 'User created successfully',
               'data' => [
                    'user' => [
                         'username' => $username,
                    ]
               ]
          ]);
     }
}
