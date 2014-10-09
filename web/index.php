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
  $model = new App\Models\CostumeModel($app["pdo"]);
  $controller = new App\Controllers\CostumeController($model, $app);
  return $controller->read();
});
$app->get('costume/add', function () use($app) {
  $model = new App\Models\CostumeModel($app["pdo"]);
  $controller = new App\Controllers\CostumeController($model, $app);
  return $controller->create();
});
$app->post('costume/add', function () use ($app) {
  $model = new App\Models\CostumeModel($app["pdo"]);
  $posts = !(empty($_POST))? $_POST: false;
  $controller = new App\Controllers\CostumeController($model, $app);
  return $controller->add($posts);

});

$app->run();
