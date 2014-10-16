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
    $notification = [
      "className" => "error",
      "message"   => "Could not add the tip. Please try again later."
    ];
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
      $approvedTokens     = $this->getAllTokensApprovedForCostume($costumeId);
      $totalTokensCostumeModel = new TotalTokensCostumeModel($this->app["pdo"]);
      $totalTokensCostume = $totalTokensCostumeModel->create($costumeId, $approvedTokens);
      $notification = [
        "className" => "success",
        "message"   => "The tip have been added."
      ];
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
  public function getAllTokensApprovedForCostume($costumeId) {
    $transactionModel   = new TransactionModel($this->app["pdo"]);
    $approvedTokens     = $transactionModel->getAllApprovedForCostume($costumeId);
    $result = 0;
    foreach ($approvedTokens as $key => $val) {
      if ($key === "tokens_amount") {
        $result += $val;
      }
    }
    return $result;
  }
  public function updateName($post, $hash) {
    $notification = [
      "className" => "error",
      "message"   => "Could not update the costume name. Please try again later."
    ];
    if (isset($_POST["costume-update-submit"])) {
      $costumeName          = mysql_escape_string((string) $post["costume-update-name"]);;
      $costumeModel         = new CostumeModel($this->app["pdo"]);
      $costume              = $costumeModel->getFromHash($hash);
      $costumeNameUpdated   = $costumeModel->updateName($costume->id, $costumeName);
      $notification = [
        "className" => "success",
        "message"   => "The costume name have been updated."
      ];
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
  public function updateImage($post, $hash) {
    $notification = [
      "className" => "error",
      "message"   => "Could not update the costume image. Please try again later."
    ];
    if (isset($_POST["costume-update-submit"])) {
      $costumeImage         = mysql_escape_string((string) $post["costume-update-image"]);;
      $costumeModel         = new CostumeModel($this->app["pdo"]);
      $costume              = $costumeModel->getFromHash($hash);
      $costumeImage         = $costumeModel->getFromId($costume->id);
      $costumeNameUpdated   = $costumeModel->updateImage($costume->id, $costumeImage->image);
      $notification = [
        "className" => "success",
        "message"   => "The costume image have been updated."
      ];
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);

  }
}
