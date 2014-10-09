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
      SELECT name, tokens, image
      FROM costumes
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_OBJ);
  }

}
