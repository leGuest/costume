<?php
namespace App\Controllers;
use App\Models\TransactionModel;
class ApproveTransactionController {

  public function __construct($app) {
    $this->app   = $app;
  }
  public function approve($isAdmin, $id) {
    if ($isAdmin === true) {
      $transactionModel       = new TransactionModel($this->app["pdo"]);
      $transactionApproved    = $transactionModel->approvePending($id);
      return true;
    }
    return false;
  }
}


