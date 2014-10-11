<?php
namespace App\Controllers;

use App\Models\TipperModel;
use Opis\Session\Session;

class RegisterTipperController {
  private $app;

  public function __construct($app) {
    $this->app = $app;
  }
  public function before($session) {
    $this->session = $session;
  }

  public function register($post, $session, $ip) {
    $notification = [
      "className" => "error",
      "message"   => "Could not register. Please try again later."
    ];
    if ($post["register-submit"]) {
      $this->before($session);
      $this->session->set("tippername", trim((string)$post["register-name"]));
      $this->session->set("tippermail", trim((string)$post["register-mail"]));
      $TipperModel = new TipperModel($this->app["pdo"]);
      $tipper      = $TipperModel->register(
        $this->session->id(),
        $this->session->get("tippername"),
        md5($post['register-mfcname']),
        $this->session->get("tippermail"),
        \hash('SHA256', $post["register-password"]),
        $ip
      );
      if ($tipper === false) {
        $notification = [
          "className" => "error",
          "message"   => "Name or MfcName already took."
        ];
      } else {
        $notification = [
          "className" => "success",
          "message"   => "You have been registered as " . $this->session->get("tippername")
        ];
      }
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
}


