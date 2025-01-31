<?php

namespace App\Model;

use App\Config\Config;
use PDO;

class Book extends Config
{
     private $table = 'books';
     public function getAll(): array
     {
          $PDO = $this->getPdo();
          $sql = "SELECT * FROM {$this->table}";
          $stmt = $PDO->prepare($sql);

          $stmt->execute();

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getById(int $id)
     {
          $PDO = $this->getPdo();
          $sql = "SELECT * FROM {$this->table} WHERE id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([':id' => $id]);

          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function create(array $data): array
     {
          $PDO = $this->getPdo();
          $sql = "INSERT INTO {$this->table} (title, author, price) VALUES (:title, :author, :price)";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':title' => $data['name'],
               ':author' => $data['brand'],
               ':price' => $data['price']
          ]);

          return [
               'id' => $PDO->lastInsertId(),
               'title' => $data['name'],
               'author' => $data['brand'],
               'price' => $data['price']
          ];
     }

     public function update(int $id, array $data): array
     {
          $PDO = $this->getPdo();
          $sql = "UPDATE {$this->table} SET title = :title, author = :author , price = :price WHERE id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':id' => $id,
               ':title' => $data['name'],
               ':author' => $data['brand'],
               ':price' => $data['price']
          ]);
          return [
               'id' => $id,
               'title' => $data['name'],
               'author' => $data['brand'],
               'price' => $data['price']
          ];
     }

     public function delete(int $id): void
     {
          $PDO = $this->getPdo();
          $sql = "DELETE FROM {$this->table} WHERE id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([':id' => $id]);
     }
}
