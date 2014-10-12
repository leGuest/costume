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
    if($hasTipper && count($hasTipper) > 0) {
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
  public function register($SID, $name, $mfcname, $mail, $password, $ip) {
    $query = "
      SELECT COUNT(*)
      FROM tipper
      WHERE name LIKE :name
      ";
    $statement = $this->pdo->prepare($query);
    $statement->execute([
      "name"    => $name
    ]);
    $tipper = $statement->fetch(PDO::FETCH_NUM);
    if((int)$tipper[0] > 0) {
      return false;
    } else {
      $query = "
        INSERT INTO tipper
        (bag, name, mfcname, mail, password, created_at, updated_at, ip)
        VALUES (:bag, :name, :mfcname, :mail, :password, :created_at, :updated_at, :ip)
        ";
      $now  = new \DateTime();
      $now  = $now->format("Y-m-d h:i:s");
      $statement = $this->pdo->prepare($query);
      $statement->execute([
        "bag"           => $SID,
        "name"          => $name,
        "mfcname"       => $mfcname,
        "mail"          => $mail,
        "password"      => $password,
        "created_at"    => $now,
        "updated_at"    => $now,
        "ip"            => $ip
      ]);
      return $this->pdo->lastInsertId();
    }
  }
  public function login($name, $password) {
    $query = "
      SELECT name, mail
      FROM tipper
      WHERE name = :name
      AND password = :password
    ";
    $password     = \hash('SHA256', $password);
    $statement    = $this->pdo->prepare($query);
    $statement->execute([
      "password"  => $password,
      "name"      => $name
    ]);
    return $statement->fetch(PDO::FETCH_OBJ);
  }
}
