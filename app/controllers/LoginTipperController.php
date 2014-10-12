<?php

namespace App\Controllers;

use App\Models\TipperModel;
use Opis\Session\Session;

class LoginTipperController {
  private $app;
  private $session;
  private $notification;
  public function __construct($app) {
    $this->app = $app;
  }
  public function setSession($session) {
    $this->session = $session;
  }
  public function getSession() {
    return $this->session;
  }
  public function login($post) {
    $this->notification = [
      "className" => "error",
      "message"   => "Could not login. Please try again later."
    ];
    if($post["login-submit"]) {
      $loginName          = mysql_escape_string((string) $post["login-name"]);;
      $loginPassword      = mysql_escape_string((string) $post["login-password"]);
      $tipperModel        = new TipperModel($this->app["pdo"]);
      $tipper             = $tipperModel->login($loginName, $loginPassword);
      if ($tipper && $tipper->name && $tipper->mail) {
        $this->session->set("tippername", $tipper->name);
        $this->session->set("tippermail", $tipper->mail);
        $this->app["session"] = $this->session;
        $this->notification = [
          "className" => "success",
          "message"   => "Welcome back, " . $this->session->get("tippername")
        ];
      } else {
        $this->notification = [
          "className" => "error",
          "message"   => "Could not find user"
        ];
      }
    }
  }
  public function render() {
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $this->notification
    ]);
  }
}
