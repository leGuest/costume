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

$app->get('/', function() use($app) {
  $controller   = new App\Controllers\ReadCostumeController($app);
  $costumeList  = $controller->readAll();
  $page         = new App\Controllers\PageController($app);
  return $page->indexAction($costumeList);
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
  $session = new Session();
  $session->clear();
  $posts = !(empty($_POST))? $_POST: false;
  $ip = \hash('SHA256', $_SERVER["REMOTE_ADDR"]);
  $controller = new App\Controllers\RegisterTipperController($app);
  return $controller->register($posts, $session, $ip);
});

$app->run();
