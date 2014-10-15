<?php

namespace App\Controllers;

use App\Models\CostumeModel;

class UnpublishCostumeController {
  public function __construct($app) {
    $this->app   = $app;
  }
  public function unpublish($isAdmin, $hash) {
    if ($isAdmin === true) {
      $costumeModel       = new CostumeModel($this->app["pdo"]);
      $costumeUnpublished = $costumeModel->unpublishPublished($hash);
      return true;
    }
    return false;
  }
}
