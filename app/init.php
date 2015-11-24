<?php

/**
 * Created by PhpStorm.
 * User: abc
 * Date: 24-Nov-15
 * Time: 11:35 AM
 */
use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Noodlehaus\Config;

use Codesource\User\User;
use Codesource\Helpers\Hash;

session_cache_limiter(false);
session_start();

ini_set('display_errors', 'On');

define("INC_ROOT", dirname(__DIR__));

require_once INC_ROOT . "/vendor/autoload.php";

$app = new Slim(array(
    'mode' => file_get_contents(INC_ROOT . "/mode"),
    'view' => new Twig(),
    'templates.path' => INC_ROOT . "/app/views"
        )
);

$app->configureMode($app->config('mode'), function() use($app) {
    $app->config = Config::load(INC_ROOT . "/app/config/{$app->config('mode')}.php");
});

require_once 'database.php';
require_once 'routes.php';

$app->container->set('user', function() {
    return new User;
});

$app->container->singleton('hash', function() use ($app) {
    return new Hash($app->config);
});

$view = $app->view();
$view->parserOptions = array('debug' => $app->config->get('twig.debug'));

$view->parserExtensions = array(new TwigExtension);




