<?php

namespace App\Controllers;

use App\Models\TipperModel;
use Opis\Session\Session;

class LogoutTipperController {
  private $app;
  private $session;
  public function __construct($app) {
    $this->app = $app;
  }
  public function setSession($session) {
    $this->session = $session;
  }
  public function getSession() {
    return $this->session;
  }
  public function logout() {
    $this->notification = [
      "className" => "error",
      "message"   => "Could not logout. Please try again later."
    ];
    if ($this->session->id()) {
      $this->session->destroy();
      $this->notification = [
        "className" => "success",
        "message"   => "You have successfully logged out"
      ];
    }
    return $this->session;
  }
  public function render() {
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $this->notification
    ]);
  }
}
