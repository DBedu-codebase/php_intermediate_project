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
          $sql = "SELECT * FROM {$this->table} WHERE author_id = :author_id"
     }

     public function getById(int $id) {}

     public function create(array $data, stdClass $payload): array {}

     public function update(int $id, array $data, stdClass $payload): array {}

     public function confirm_author(int $id, stdClass $payload): void {}

     public function delete(int $id): void {}
}
