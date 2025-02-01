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
     public function searchAndFilter(array $data): array {}

     public function getById($id) {}

     public function create(array $data): array {}

     public function update(int $id, array $data): array {}

     public function delete(int $id): void {}
     public function deleteAll(): void {}
}
