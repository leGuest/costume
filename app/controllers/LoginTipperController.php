<?php

namespace App\Controllers;

use App\Models\TipperModel;
use Opis\Session\Session;

class LoginTipperController {
  private $app;
  private $session;
  public function __construct($app) {
    $this->app = $app;
  }

  public function login($post) {
    $notification = [
      "className" => "error",
      "message"   => "Could not login. Please try again later."
    ];
    if($post["login-submit"]) {
      $loginName          = mysql_escape_string((string) $post["login-name"]);;
      $loginPassword      = mysql_escape_string((string) $post["login-password"]);
      $tipperModel        = new TipperModel($this->app["pdo"]);
      $tipper             = $tipperModel->login($loginName, $loginPassword);
      if ($tipper && $tipper->name && $tipper->mail) {
        $this->session = new Session();
        $this->session->set("tippername", $tipper->name);
        $this->session->set("tippermail", $tipper->mail);
        $notification = [
          "className" => "success",
          "message"   => "Welcome back, " . $this->session->get("tippername")
        ];
      } else {
        $notification = [
          "className" => "error",
          "message"   => "Could not find user"
        ];
      }
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
}
