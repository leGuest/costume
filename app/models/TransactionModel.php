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
      (id_tipper, id_costume, tokens_amount, id_status)
      VALUES(:tipper, :costume, :tokens, :status)
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "tipper"    => $tipper,
      "costume"   => $costume,
      "tokens"    => $tokens,
      "status"    => 1
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
  public function getFromId($id){
    $query = "
      SELECT id_tipper, id_costume, tokens_amount
      FROM tipper_transaction
      WHERE id = :id
    ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "id"    => $id
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
  public function getAllApprovedForCostume($costume) {
    $query = "
      SELECT id_tipper, id_costume, tokens_amount
      FROM tipper_transaction
      WHERE id_status = 2
      AND id_costume = :costume
    ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "costume"    => $costume
    ]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
  }
  public function getAll() {
    $query = "
      SELECT tipper_transaction.id,
        costume.name as costume_name,
        tokens_amount, tipper.name as tipper_name,
        tipper_transaction.id_status
      FROM tipper_transaction
      INNER JOIN costume  ON
        costume.id = tipper_transaction.id_costume
      INNER JOIN tipper   ON
          tipper.id  = tipper_transaction.id_tipper
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
  }
  public function approvePending($id) {
    $query = "
        UPDATE tipper_transaction
        SET id_status = 2
        WHERE id = :id
    ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "id"      => $id
    ]);
    return $id;
  }
  public function disapprovePending($id) {
    $query = "
        UPDATE tipper_transaction
        SET id_status = 3
        WHERE id = :id
    ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "id"      => $id
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
  public function updateCostumeName($id, $costumeId) {
    $query = "
      UPDATE tipper_transaction
      SET id_costume = :costumeId
      WHERE id = :id
    ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "id"          => $id,
      "costumeId"   => $costumeId
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
  public function updateTokensAmount($id, $amount) {
    $query = "
      UPDATE tipper_transaction
      SET tokens_amount = :tokens_amount
      WHERE id = :id
    ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "id"            => $id,
      "tokens_amount" => $amount
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
}
