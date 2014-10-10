<?php
namespace App\Controllers;

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
}

