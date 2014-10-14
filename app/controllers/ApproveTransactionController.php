<?php
namespace App\Controllers;
use App\Models\TransactionModel;
use App\Models\TotalTokensCostumeModel;
class ApproveTransactionController {

  public function __construct($app) {
    $this->app   = $app;
  }
  public function approve($isAdmin, $id) {
    if ($isAdmin === true) {
      $transactionModel         = new TransactionModel($this->app["pdo"]);
      $transactionApproved      = $transactionModel->approvePending($id);
      $transaction              = $transactionModel->getFromId($id);
      $totalTokensCostumeModel  = new TotalTokensCostumeModel($this->app["pdo"]);
      $totalTokensCostume       = $totalTokensCostumeModel->create($transaction->id_costume, $transaction->tokens_amount);
      return true;
    }
    return false;
  }
}


