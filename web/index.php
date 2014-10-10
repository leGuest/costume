<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Extension\TwigExtension;

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
  return $hash;
});
$app->run();
