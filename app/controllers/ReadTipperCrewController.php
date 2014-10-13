<?php

namespace App\Controllers;

use App\Models\CrewModel;

class ReadTipperCrewController {
  private $app;
  public function __construct($app) {
    $this->app = $app;
  }
  public function isAdmin($session) {
    $this->session = $session;
    if ($this->session->id() && $this->session->get("tippername")) {
      $crewModel  = new CrewModel($this->app["pdo"]);
      $isAdmin    = $crewModel->isAdmin($this->session->get("tippername") || 0);
      return $isAdmin;
    }
    return false;
  }
}
