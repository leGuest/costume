<?php
namespace App\Models;

use PDO;

class TipperModel {
  private $pdo;
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }
  public function create($tipper) {
    $query = "
      SELECT id
      FROM tipper
      WHERE name = :name
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "name" => $tipper
    ]);
    $hasTipper = $statement->fetch(PDO::FETCH_OBJ);
    if(count($hasTipper) > 0) {
      $tipper = $hasTipper->id;
    } else {
      $query = "
        INSERT INTO tipper
        (name)
        VALUES (:name)
        ";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        "name"    => $tipper,
      ]);
      return $this->pdo->lastInsertId();
    }
  }
}
