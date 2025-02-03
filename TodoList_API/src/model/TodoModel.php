<?php

namespace App\Model;

use App\Config\Config;
use PDO;
use stdClass;

class TodoModel extends Config
{
     private $table = 'tasks';

     // public function getAll(array $paramsQuery = [], stdClass $payload = null): array
     // {
     //      $PDO = $this->getPdo();

     //      $paramsQuery = array_merge([
     //           'page' => $_GET['page'] ?? 1,
     //           'limit' => $_GET['limit'] ?? 10,
     //           'orderBy' => $_GET['orderBy'] ?? 'ASC',
     //           'status' => $_GET['status'] ?? ''
     //      ], $paramsQuery);

     //      $offset = ($paramsQuery['page'] - 1) * $paramsQuery['limit'];

     //      $sql = "SELECT * FROM {$this->table}";

     //      if (!empty($paramsQuery['status'])) {
     //           $sql .= " WHERE status = :status";
     //      }

     //      $sql .= " AND author_id = :author_id";

     //      $sql .= " ORDER BY title {$paramsQuery['orderBy']} LIMIT {$paramsQuery['limit']} OFFSET {$offset}";

     //      $stmt = $PDO->prepare($sql);

     //      $stmt->execute(array_merge([
     //           ':author_id' => $payload->id
     //      ], !empty($paramsQuery['status']) ? [':status' => $paramsQuery['status']] : []));

     //      return $stmt->fetchAll(PDO::FETCH_ASSOC);
     // }
     /******  4a8d04eb-06c8-4137-9663-5c62cf6b0731  *******/

     public function getAll(array $paramsQuery = [], stdClass $payload = null): array
     {
          $PDO = $this->getPdo();

          // Merge query parameters with defaults
          $paramsQuery = array_merge([
               'page' => $_GET['page'] ?? 1,
               'limit' => $_GET['limit'] ?? 10,
               'orderBy' => $_GET['orderBy'] ?? 'ASC',
               'status' => $_GET['status'] ?? ''
          ], $paramsQuery);

          $offset = ($paramsQuery['page'] - 1) * $paramsQuery['limit'];

          // Start SQL Query
          $sql = "SELECT * FROM {$this->table} WHERE author_id = :author_id";

          // Add status filter if provided
          $queryParams = [':author_id' => $payload->id];
          if (!empty($paramsQuery['status'])) {
               $sql .= " AND status = :status";
               $queryParams[':status'] = $paramsQuery['status'];
          }

          // Ordering and Pagination
          $sql .= " ORDER BY title " . ($paramsQuery['orderBy'] === 'DESC' ? 'DESC' : 'ASC');
          $sql .= " LIMIT :limit OFFSET :offset";

          // Prepare and execute query
          $stmt = $PDO->prepare($sql);
          $stmt->bindValue(':limit', (int) $paramsQuery['limit'], PDO::PARAM_INT);
          $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

          foreach ($queryParams as $key => $value) {
               $stmt->bindValue($key, $value);
          }

          $stmt->execute();

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getById(int $id)
     {
          $PDO = $this->getPdo();
          $sql = "SELECT * FROM {$this->table} WHERE task_id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([':id' => $id]);

          return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function create(array $data, stdClass $payload): array
     {
          $PDO = $this->getPdo();
          $sql = "INSERT INTO {$this->table} (title, description, author_id) VALUES (:title, :description, :author_id)";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':title' => $data['title'],
               ':description' => $data['description'],
               ':author_id' => $payload->id,
          ]);

          return [
               'id' => $PDO->lastInsertId(),
               'title' => $data['title'],
               'description' => $data['description'],
               'author_id' => $payload->id,
          ];
     }

     public function update(int $id, array $data, stdClass $payload): array
     {
          $PDO = $this->getPdo();
          $sql = "UPDATE {$this->table} SET title = :title, description = :description WHERE task_id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':id' => $id,
               ':title' => $data['title'],
               ':description' => $data['description'],
          ]);
          return [
               'id' => $id,
               'title' => $data['title'],
               'description' => $data['description'],
               'author_id' => $payload->id,
          ];
     }

     public function confirm_author(int $id, stdClass $payload): void
     {
          $PDO = $this->getPdo();
          $sql = "SELECT author_id FROM {$this->table} WHERE task_id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([':id' => $id]);
          $dbAuthorId = $stmt->fetchColumn();

          if ($dbAuthorId !== $payload->id) {
               http_response_code(400);
               echo json_encode(['errors' => 'Unauthorized']);
               exit();
          }
     }

     public function delete(int $id): void
     {
          $PDO = $this->getPdo();
          $sql = "DELETE FROM {$this->table} WHERE post_id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([':id' => $id]);
     }
}
