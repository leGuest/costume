<?php
namespace App\Controllers;

use App\Models\TipperModel;
use Opis\Session\Session;

class RegisterTipperController {
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
  public function register($post, $ip) {
    $this->notification = [
      "className" => "error",
      "message"   => "Could not register. Please try again later."
    ];
    if ($post["register-submit"]) {
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
        $this->notification = [
          "className" => "error",
          "message"   => "Name or MfcName already took."
        ];
      } else {
        $this->notification = [
          "className" => "success",
          "message"   => "You have been registered as " . $this->session->get("tippername")
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
