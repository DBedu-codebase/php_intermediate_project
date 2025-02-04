<?php

namespace App\Model;

use App\Config\Config;
use PDO;
use stdClass;

class TodoModel extends Config
{
     private $table = 'tasks';

     public function getAll(array $paramsQuery, stdClass $payload = null): array
     {
          $PDO = $this->getPdo();
          $sql = "SELECT * FROM {$this->table} WHERE author_id = :author_id";

          $queryParams = [':author_id' => $payload->id];

          if (isset($paramsQuery['status']) && $paramsQuery['status'] !== '') {
               $sql .= ' AND COALESCE(status, 0) = :status';
               $queryParams[':status'] = (int) $paramsQuery['status'];
          }

          $stmt = $PDO->prepare("{$sql} ORDER BY task_id {$paramsQuery['orderBy']} LIMIT :limit OFFSET :offset");
          $stmt->bindValue(':limit', (int) $paramsQuery['limit'], PDO::PARAM_INT);
          $stmt->bindValue(':offset', (int) (($paramsQuery['page'] - 1) * $paramsQuery['limit']), PDO::PARAM_INT);
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
          $sql = "UPDATE {$this->table} SET title = :title, description = :description,status = :status, updated_at = :updated_at WHERE task_id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([
               ':id' => $id,
               ':title' => $data['title'],
               ':description' => $data['description'],
               ':status' => $data['status'],
               ':updated_at' => date('Y-m-d H:i:s')
          ]);
          return [
               'id' => $id,
               'title' => $data['title'],
               'description' => $data['description'],
               'status' => $data['status'],
               'author_id' => $payload->id,
               'updated_at' => date('Y-m-d H:i:s')
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
          $sql = "DELETE FROM {$this->table} WHERE task_id = :id";
          $stmt = $PDO->prepare($sql);
          $stmt->execute([':id' => $id]);
     }
}
