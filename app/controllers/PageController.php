<?php
namespace App\Controllers;

use App\Models\CostumeModel;

class PageController{
  public function __construct($app) {
    $this->app   = $app;
  }

  public function indexAction($costumeList) {
    return $this->app["twig"]->render("CostumeList.twig", [
      "costumes" => $costumeList
    ]);
  }

  public function addCostumeAction() {
    return $this->app["twig"]->render("CostumeAdd.twig");
  }

  public function addTipToCostumeAction($hash) {
    $costumeModel = new CostumeModel($this->app["pdo"]);
    $costume = $costumeModel->getFromHash($hash);
    return $this->app["twig"]->render("CostumeUpdate.twig", [
      "costumeName" => $costume->name,
      "costumeHash"        => $hash
    ]);
  }

  public function registerTipperAction() {
    return $this->app["twig"]->render("TipperRegister.twig");
  }

  public function loginTipperAction () {
    return $this->app["twig"]->render("TipperLogin.twig");

  }
}

