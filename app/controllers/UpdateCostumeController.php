<?php
namespace App\Controllers;
use App\Models\CostumeModel;
use App\Models\TipperModel;
use App\Models\TransactionModel;
use App\Models\TotalTokensCostumeModel;
use App\Models\TotalTokensTipperModel;
use Silex\Application;

class UpdateCostumeController {

  public function __construct($app) {
    $this->app   = $app;
  }
  public function update($post, $hash) {
    if (isset($post["costume-add-submit"])) {
      $costumeTokens      = mysql_escape_string((string)(int)$post["costume-add-tokens"]);
      $costumeTipperName  = mysql_escape_string((string) $post["costume-add-tippername"]);;
      $costumeModel       = new CostumeModel($this->app["pdo"]);
      $costume            = $costumeModel->getFromHash($hash);
      $costumeId          = $costume->id;
      $tipperModel        = new TipperModel($this->app["pdo"]);
      $tipper             = $tipperModel->create($costumeTipperName, $costumeId);
      $transactionModel   = new TransactionModel($this->app["pdo"]);
      $transaction        = $transactionModel->create($tipper, $costumeId, $costumeTokens);
      $totalTokensCostumeModel = new TotalTokensCostumeModel($this->app["pdo"]);
      $totalTokensCostume = $totalTokensCostumeModel->create($costumeId, $costumeTokens);
      $notification = [
        "className" => "success",
        "message"   => "The tip have been added."
      ];
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
}
