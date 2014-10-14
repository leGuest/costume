<?php
namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TotalTokensCostumeModel;

class DisapproveTransactionController {
  public function __construct($app) {
    $this->app   = $app;
  }
  public function disapprove($isAdmin, $id) {
    if ($isAdmin === true) {
      $transactionModel         = new TransactionModel($this->app["pdo"]);
      $transactionApproved      = $transactionModel->disapprovePending($id);
      $transaction              = $transactionModel->getFromId($id);
      $totalTokensCostumeModel  = new TotalTokensCostumeModel($this->app["pdo"]);
      $totalTokensCostume       = $totalTokensCostumeModel->create($transaction->id_costume, -($transaction->tokens_amount));
      return true;
    }
    return false;

  }
}
