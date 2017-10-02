<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// meetup api
$container['meetup'] = function ($c) {
    $settings = $c->get('settings')['meetup'];
    $meetup = new Aoloe\CoderDojoZh\MeetupRequest($settings['groupName'], $settings['apiKey']);
    return $meetup;
};

// data storing in json files
$container['storage'] = function ($c) {
    $settings = $c->get('settings')['storage'];
    $storage = new Aoloe\CoderDojoZh\Storage($settings['path']);
    return $storage;
};

// data filtering and joining
$container['data'] = function ($c) {
    $settings = $c->get('settings')['data'];
    $data = new Aoloe\CoderDojoZh\Data($c, $settings['topic'], $settings['banner']);
    return $data;
};
