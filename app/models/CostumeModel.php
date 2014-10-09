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
      SELECT DISTINCT(name), tokens, image
      FROM costumes
      ORDER BY tokens DESC
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll();
  }
  public function create($name, $tokens, $tipper)
  {
    $query = "
     INSERT INTO costumes
     (`name`, `tokens`, `tipper`)
     VALUES (:name, :tokens, :tipper)
     ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "name"    => $name,
      "tokens"  => $tokens,
      "tipper"  => $tipper
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
}
