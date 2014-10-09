<?php

namespace App\Controllers;
use App\Models\CostumeModel;
use Silex\Application;

class CostumeController {

  public function __construct(CostumeModel $model, $app) {
    $this->model = $model;
    $this->app   = $app;
  }

  public function read() {
    return $this->app["twig"]->render("CostumeList.twig", [
      "costumes" => (array) $this->model->getAll()
    ]);
  }

  public function create() {
    return $this->app["twig"]->render("CostumeAdd.twig");
  }

  public function add($post) {
    /** @TODO
     * mini validator service
     * cast type
     * mysql escape string
     * check for not empty
     */
    $notification = [
      "className" => "error",
      "message"   => "Could not create the costume. Please try again later."
    ];
    if (isset($post["costume-submit"])) {
      $costumeName        = mysql_escape_string((string) $post["costume-name"]);
      $costumeTokens      = mysql_escape_string((string)(int)$post["costume-tokens"]);
      $costumeTipperName  = mysql_escape_string((string) $post["costume-tippername"]);;
      $insert             = $this->model->create($costumeName, $costumeTokens, $costumeTipperName);
      if(count($insert)) {
        $notification = [
          "className" => "success",
          "message"   => "The costume have been added."
        ];
      }
    }
    return $this->app["twig"]->render("Notification.twig", [
      "notification" => $notification
    ]);
  }
}
