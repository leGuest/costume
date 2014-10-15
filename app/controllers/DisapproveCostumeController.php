<?php

namespace App\Controllers;

use App\Models\CostumeModel;

class DisapproveCostumeController {
  public function __construct($app) {
    $this->app   = $app;
  }
  public function disapprove($isAdmin, $hash) {
    if ($isAdmin === true) {
      $costumeModel         = new CostumeModel($this->app["pdo"]);
      $costumeDisapproved   = $costumeModel->disapprovePending($hash);
      return true;
    }
    return false;
  }
}
