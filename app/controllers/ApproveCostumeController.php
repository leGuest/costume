<?php

namespace App\Controllers;
use App\Models\CostumeModel;
class ApproveCostumeController {

  public function __construct($app) {
    $this->app   = $app;
  }
  public function approve($isAdmin, $hash) {
    if ($isAdmin === true) {
      $costumeModel     = new CostumeModel($this->app["pdo"]);
      $costumeApproved  = $costumeModel->approvePending($hash);
      return true;
    }
    return false;
  }
}
