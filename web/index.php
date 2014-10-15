<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Extension\TwigExtension;
use Opis\Session\Session;

$app = new Silex\Application();
$env = "dev";
if (isset($env) && in_array($env, array("prod", "dev", "test"))) {
  $app["env"] = $env;
  $app->register(new Whoops\Provider\Silex\WhoopsServiceProvider);
} else {
  $app["env"] = "prod";
}
$app["pdo"] = new \PDO("sqlite:../database/costumes.sqlite");
$app->register(new Silex\Provider\TwigServiceProvider, array(
  "twig.path" => __DIR__ . "/../app/views"
  //, "twig.options" => array("cache" => __DIR__ . "/../cache/twig")
));
$app["session"] = new Session();
$app->before(function () use ($app) {
  if ($app["session"] && $app["session"]->get("tippername")) {
    echo "Welcome, " . $app["session"]->get("tippername");
  }
});
$app->get('/', function() use($app) {
  $controller         = new App\Controllers\ReadCostumeController($app);
  $costumeList        = $controller->readAll();
  $isAdminController  = new App\Controllers\ReadTipperCrewController($app);
  $isAdmin            = $isAdminController->isAdmin($app["session"]);
  $page               = new App\Controllers\PageController($app);
  return $page->indexAction($costumeList, $isAdmin);
});
$app->get('costume/add', function () use($app) {
  $controller = new App\Controllers\PageController($app);
  return $controller->addCostumeAction();
});
$app->post('costume/add', function () use ($app) {
  $posts = !(empty($_POST))? $_POST: false;
  $controller = new App\Controllers\AddCostumeController($app);
  return $controller->add($posts);
});
$app->get('costume/tip/{hash}', function ($hash) use ($app) {
  $controller = new App\Controllers\PageController($app);
  return $controller->addTipToCostumeAction($hash);
});
$app->get("costume/approve/{hash}", function ($hash) use ($app) {
  $isAdminController  = new App\Controllers\ReadTipperCrewController($app);
  $isAdmin            = $isAdminController->isAdmin($app["session"]);
  $controller         = new App\Controllers\ApproveCostumeController($app);
  $controller->approve($isAdmin, $hash);
  $controller         = new App\Controllers\ReadCostumeController($app);
  $costumeList        = $controller->readAll();
  $page               = new App\Controllers\PageController($app);
  return $page->indexAction($costumeList, $isAdmin);
});
$app->get("costume/disapprove/{hash}", function ($hash) use ($app) {
  $isAdminController  = new App\Controllers\ReadTipperCrewController($app);
  $isAdmin            = $isAdminController->isAdmin($app["session"]);
  $controller         = new App\Controllers\DisapproveCostumeController($app);
  $controller->disapprove($isAdmin, $hash);
  $controller         = new App\Controllers\ReadCostumeController($app);
  $costumeList        = $controller->readAll();
  $page               = new App\Controllers\PageController($app);
  return $page->indexAction($costumeList, $isAdmin);
});
$app->get("costume/unpublish/{hash}", function ($hash) use ($app) {
  $isAdminController  = new App\Controllers\ReadTipperCrewController($app);
  $isAdmin            = $isAdminController->isAdmin($app["session"]);
  $controller         = new App\Controllers\UnpublishCostumeController($app);
  $controller->unpublish($isAdmin, $hash);
  $controller         = new App\Controllers\ReadCostumeController($app);
  $costumeList        = $controller->readAll();
  $page               = new App\Controllers\PageController($app);
  return $page->indexAction($costumeList, $isAdmin);
});
$app->post('costume/tip/{hash}', function ($hash) use ($app) {
  $controller = new App\Controllers\UpdateCostumeController($app);
  $posts = !(empty($_POST))? $_POST: false;
  return $controller->update($posts, $hash);
});
$app->get('account/register', function () use ($app) {
  $controller = new App\Controllers\PageController($app);
  return $controller->registerTipperAction();
});
$app->post('account/register', function () use ($app) {
  $posts = !(empty($_POST))? $_POST: false;
  $ip = \hash('SHA256', $_SERVER["REMOTE_ADDR"]);
  $controller = new App\Controllers\RegisterTipperController($app);
  $controller->setSession($app["session"]);
  $controller->register($posts, $ip);
  $app["session"] = $controller->getSession();
  return $controller->render();
});
$app->get('account/login', function () use ($app) {
  $controller = new App\Controllers\PageController($app);
  return $controller->loginTipperAction();
});
$app->post('account/login', function () use ($app) {
  $posts = !(empty($_POST))? $_POST: false;
  $controller = new App\Controllers\LoginTipperController($app);
  $controller->setSession($app["session"]);
  $controller->login($posts);
  $app["session"] = $controller->getSession();
  return $controller->render();
});

$app->get("account/logout", function () use ($app) {
  $controller = new App\Controllers\LogoutTipperController($app);
  $controller->setSession($app["session"]);
  $app["session"] = $controller->logout();
  return $controller->render();
});
$app->get("transaction/", function () use ($app) {
  $isAdminController    = new App\Controllers\ReadTipperCrewController($app);
  $isAdmin              = $isAdminController->isAdmin($app["session"]);
  $page                 = new App\Controllers\PageController($app);
  return $page->readTransactionAction($isAdmin);
});
$app->get("transaction/approve/{id}", function ($id) use ($app) {
  $isAdminController    = new App\Controllers\ReadTipperCrewController($app);
  $isAdmin              = $isAdminController->isAdmin($app["session"]);
  $controller           = new App\Controllers\ApproveTransactionController($app);
  $controller->approve($isAdmin, $id);
  $page                 = new App\Controllers\PageController($app);
  return $page->readTransactionAction($isAdmin);
});
$app->get("transaction/discard/{id}", function ($id) use ($app) {
  $isAdminController    = new App\Controllers\ReadTipperCrewController($app);
  $isAdmin              = $isAdminController->isAdmin($app["session"]);
  $controller           = new App\Controllers\DisapproveTransactionController($app);
  $controller->Disapprove($isAdmin, $id);
  $page                 = new App\Controllers\PageController($app);
  return $page->readTransactionAction($isAdmin);
});

$app->run();
