<?php

require 'vendor/autoload.php';

$app = new \Slim\App();


$app->get('/', function ($request, $response, $args) {
    return "This is a restful api using slim micro framework.";
});

require 'src/routes/customers.php';
require 'src/library/Database.php';

// Run app
$app->run();