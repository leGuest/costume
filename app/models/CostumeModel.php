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
      SELECT id, name , image, hash_id, id_status
      FROM costume
      ORDER BY id_status DESC
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
  }
  public function getFromHash($hash) {
    $query = "
      SELECT id, name
      FROM costume
      WHERE hash_id = :hash
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "hash" => $hash
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
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
    if($costume && count($costume) > 0) {
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
  public function approvePending($hash_id) {
    $query = "
      UPDATE costume
      SET id_status = 2
      WHERE hash_id = :hash_id
    ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "hash_id" => $hash_id
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
}
