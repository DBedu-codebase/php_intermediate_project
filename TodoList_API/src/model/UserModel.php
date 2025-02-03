<?php

namespace App\Model;

use App\Config\Config;
use PDO;

class UserModel extends Config
{
     private $table = 'user';

     public function getUniqueUser(string $email, string $name): array
     {
          $PDO = $this->getPdo();
          $sql = "SELECT email,name FROM {$this->table} WHERE email = :email OR name = :name";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':email' => $email,
               ':name' => $name,
          ]);

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     public function getUniqueUserEmail(string $email): array
     {
          $PDO = $this->getPdo();
          $sql = "SELECT * FROM {$this->table} WHERE email = :email";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':email' => $email,
          ]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          return $result;
     }
     public function PostUniqueUser(string $email, string $name, string $password)
     {
          $PDO = $this->getPdo();
          $sql = "INSERT INTO user (email,name,password) VALUES (:email,:name,:password)";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':email' => $email,
               ':name' => $name,
               ':password' => $password,
          ]);
          return json_encode([
               'message' => 'User created successfully',
               'data' => [
                    'user' => [
                         'email' => $email,
                         'name' =>  $name,
                    ]
               ]
          ]);
     }
}
