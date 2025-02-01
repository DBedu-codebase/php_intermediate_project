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
     public function searchAndFilter(array $data): array
     {
          $books = $this->getAll();
          $search = strtolower($data["simple-search"]);
          $price = $data["price"];

          // Filter books based on search
          if ($search) $books = array_filter($books, fn($book) => strpos(strtolower($book['title']), $search) !== false);
          // Sort books based on price
          usort($books, fn($a, $b) => ($price === 'high') ? $b['price'] <=> $a['price'] : $a['price'] <=> $b['price']);
          return array_values($books); // Reset array keys
     }

     /******  4ddf9f61-0ecb-467e-8db9-dde7e5128d10  *******/
     public function getById($id)
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
     public function deleteAll(): void
     {
          $PDO = $this->getPdo();
          $sql = "DELETE FROM {$this->table}";
          $stmt = $PDO->prepare($sql);
          $stmt->execute();
     }
}
