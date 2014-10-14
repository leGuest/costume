<?php
namespace App\Controllers;

use App\Models\CostumeModel;
use App\Models\TransactionModel;

class PageController{
  public function __construct($app) {
    $this->app   = $app;
  }

  public function indexAction($costumeList, $isAdmin) {
    return $this->app["twig"]->render("CostumeList.twig", [
      "costumes"  => $costumeList,
      "admin"     => $isAdmin || false
    ]);
  }

  public function addCostumeAction() {
    return $this->app["twig"]->render("CostumeAdd.twig");
  }

  public function addTipToCostumeAction($hash) {
    $costumeModel = new CostumeModel($this->app["pdo"]);
    $costume = $costumeModel->getFromHash($hash);
    return $this->app["twig"]->render("CostumeUpdate.twig", [
      "costumeName" => $costume->name,
      "costumeHash"        => $hash
    ]);
  }

  public function registerTipperAction() {
    return $this->app["twig"]->render("TipperRegister.twig");
  }

  public function loginTipperAction () {
    return $this->app["twig"]->render("TipperLogin.twig");

  }

  public function readTransactionAction($isAdmin) {
    $transactions = false;
    if ($isAdmin === true) {
      $transactionModel = new TransactionModel($this->app["pdo"]);
      $transactions = $transactionModel->getAll();
    }
    return $this->app["twig"]->render("TransactionList.twig", [
      "transactions" => $transactions
    ]);
  }
}

