<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}


if ($_SERVER['HTTP_HOST'] === 'graphicslab.org') {
    $pathRoot= dirname($_SERVER['DOCUMENT_ROOT']);
    $pathRoot .= '/dojo-registration';
} else {
    $pathRoot = __DIR__ . '/..';
}

require $pathRoot . '/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require $pathRoot . '/src/settings-private.php' ;
$settings += require $pathRoot . '/src/settings.php' ;
$app = new \Slim\App(['settings' => $settings]);

// Set up dependencies
require $pathRoot . '/src/dependencies.php';

// Register middleware
require $pathRoot . '/src/middleware.php';

// Register routes
require $pathRoot . '/src/routes.php';

// Run app
$app->run();
