<?php
namespace App\Controllers;
use App\Models\CostumeModel;
use App\Models\TransactionModel;

class UpdateTransactionController {
  public function __construct($app) {
    $this->app   = $app;
  }
  public function updateCostumeName($isAdmin, $post, $id) {
    $notification = [
      "className" => "error",
      "message"   => "Could not update the costume name for the transaction. Please try again later."
    ];
    if ($isAdmin === true && isset($post["transaction-update-submit"])) {
      $costumeName    = mysql_escape_string((string) $post["transaction-update-costumename"]);;
      $costumeModel   = new CostumeModel($this->app["pdo"]);
      $costume        = $costumeModel->getFromName($costumeName);
      $transactionModel = new TransactionModel($this->app["pdo"]);
      $transaction    = $transactionModel->updateCostumeName($id, $costume->id);
      $notification = [
        "className" => "success",
        "message"   => "The costume name for the transaction have been added."
      ];
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }

  public function updateTokensAmount($isAdmin, $post, $id) {
    $notification = [
      "className" => "error",
      "message"   => "Could not update the tokens amount for the transaction. Please try again later."
    ];
    if ($isAdmin === true && isset($post["transaction-update-submit"])) {
      $transactionTokensAmount    = (int) mysql_escape_string((string) $post["transaction-update-tokensamount"]);;
      $transactionModel           = new TransactionModel($this->app["pdo"]);
      $transaction                = $transactionModel->updateTokensAmount($id, $transactionTokensAmount);
      $notification = [
        "className" => "success",
        "message"   => "The tokens amount for the transaction have been added."
      ];
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
}
