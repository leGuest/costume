<?php
namespace App\Models;

use PDO;

class TotalTokensCostumeModel {
  private $pdo;
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }
  public function get($costume) {
    $query = "
      SELECT id, total
      FROM total_token_costume
      WHERE id_costume = :costume
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "costume"    => $costume,
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);

  }
  public function create($costume, $tokens) {
    $query = "
      SELECT id, total
      FROM total_token_costume
      WHERE id_costume = :costume
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "costume"    => $costume,
    ]);
    $hasTotalTokens = $statement->fetch(PDO::FETCH_OBJ);
    if(count($hasTotalTokens) > 0) {
      $query = "
        UPDATE total_token_costume
        SET total = :total
        WHERE id_costume = :costume
        ";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        "costume"    => $costume,
        "total"      => $hasTotalTokens->total + $tokens
      ]);
      $addToTotal = $statement->fetch(PDO::FETCH_OBJ);
    } else {
      $query = "
        INSERT INTO total_token_costume
        (id_costume, total)
        VALUES (:costume, :total)
        ";
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        "costume" => $costume,
        "total"   => $tokens
      ]);
      return $statement->fetch(PDO::FETCH_OBJ);
    }
  }
}
