<?php

namespace App\Controllers;
use App\Models\CostumeModel;
use App\Models\TipperModel;
use App\Models\TransactionModel;
use App\Models\TotalTokensCostumeModel;
use App\Models\TotalTokensTipperModel;
use Silex\Application;

class AddCostumeController {

  public function __construct($app) {
    $this->app   = $app;
  }
  public function add($post) {
    /** @TODO
     * mini validator service
     * cast type
     * mysql escape string
     * check for not empty
     * check if not already exists (trim), deletespace, uppercase it, and check
     */
    $notification = [
      "className" => "error",
      "message"   => "Could not create the costume. Please try again later."
    ];
    if (isset($post["costume-submit"])) {
      $costumeName        = mysql_escape_string((string) $post["costume-name"]);
      $costumeTokens      = mysql_escape_string((string)(int)$post["costume-tokens"]);
      $costumeTipperName  = mysql_escape_string((string) $post["costume-tippername"]);;
      $costumeModel             = new CostumeModel($this->app["pdo"]);
      $costumeLastInsertId      = $costumeModel->create($costumeName);
      $tipperModel              = new TipperModel($this->app["pdo"]);
      $tipperLastInsertId       = $tipperModel->create($costumeTipperName);
      $transactionModel         = new TransactionModel($this->app["pdo"]);
      $transactionLastInsertId  = $transactionModel->create($tipperLastInsertId, $costumeLastInsertId, $costumeTokens);
      $totalTokensCostumeModel  = new TotalTokensCostumeModel($this->app["pdo"]);
      $totalTokensCostumeLastInsertId = $totalTokensCostumeModel->create($costumeLastInsertId, $costumeTokens);

      $notification = [
        "className" => "success",
        "message"   => "The costume have been added."
      ];
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
}
