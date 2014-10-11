<?php
namespace App\Models;

use PDO;

class TransactionModel {
  private $pdo;
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }
  public function create($tipper, $costume, $tokens) {
    $query = "
      INSERT INTO tipper_transaction
      (id_tipper, id_costume, tokens_amount)
      VALUES(:tipper, :costume, :tokens)
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "tipper"    => $tipper,
      "costume"   => $costume,
      "tokens"    => $tokens
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);

  }
}
