<?php
namespace App\Models;

use PDO;

class CostumeModel {
  private $pdo;
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }
  public function getAll() {
    $query = "
      SELECT id, name , image, hash_id
      FROM costume
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
  }
  public function create($name)
  {
    $query = "
      SELECT id
      FROM costume
      WHERE name LIKE :name
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "name" => $name
    ]);
    $costume = $statement->fetch(PDO::FETCH_OBJ);
    if(count($costume) > 0) {
      return $costume->id;
    }
    $query = "
      INSERT INTO costume
      (`name`, `hash_id`)
      VALUES (:name, :hash_id)
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "name"    => $name,
      "hash_id" => hash("crc32b", $name)
    ]);
    return $this->pdo->lastInsertId();
  }
}
