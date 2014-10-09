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
      "costumes" => [(array) $this->model->getAll()]
    ]);
  }

  public function create() {
    return $this->app["twig"]->render("CostumeAdd.twig");
  }
}
