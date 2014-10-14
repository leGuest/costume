<?php
namespace App\Models;

use PDO;

class CrewModel {
  private $pdo;
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }
  public function isAdmin($tipper) {
    $query = "
      SELECT COUNT(id)
      FROM tipper
      WHERE name = :name
      AND id_crew = 2
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "name" => $tipper
    ]);
    return (int)$statement->fetch(PDO::FETCH_NUM)[0] > 0;
  }
}
