<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

//enable me to use $app->redirectTo(); in statement below
$app = new \Anax\MVC\CApplicationBasic($di);

$app->session(); // Will load the session service which also starts the session



$di->set('CommentController', function() use ($di) {
    $controller = new Mos\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});


$di->set('PostsController', function() use ($di) {
    $controller = new Krri\Posts\PostsController();
    $controller->setDI($di);
    return $controller;
});

// sets variable form to the CForm class in vendor/mos... etc
$di->set('form', '\Mos\HTMLForm\CForm');



$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/db_config_mysql.php');
    $db->connect();
    return $db;
});




$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

