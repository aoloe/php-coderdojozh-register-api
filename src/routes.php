<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

// TODO: we might want return a 404 instead of crashing on exception when an url is not found

$app->get('/event/{id}/rvsps', function (Request $request, Response $response, array $args) {
    $this->logger->info("coderdojo-zh 'rvsps' route");
    $eventId = (int) $args['id'];
    $result = $this->data->getRvsp($eventId);
    return $response
        ->withJson($result)
        ->withHeader('Access-Control-Allow-Origin', 'http://coderdojozh.github.io')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET');
});

$app->get('/event/{id}', function (Request $request, Response $response, array $args) {
    $this->logger->info("coderdojo-zh '/event' route");
    $eventId = (int) $args['id'];
    $result = $this->data->getEvent($eventId);
    return
        $response->withJson($result)
        ->withHeader('Access-Control-Allow-Origin', 'http://coderdojozh.github.io')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET');
});

$app->post('/event/{eventId}/participant/{userId}', function (Request $request, Response $response, array $args) {
    $result = false;

    $this->logger->info("coderdojo-zh post '/event/participant'");
    $eventId = (int) $args['eventId'];
    $userId = (int) $args['userId'];
    $values = $request->getParsedBody();

    if (array_key_exists('count', $values)) {
        $this->data->setParticipants($eventId, $userId, $values['count']);
    }

    return $response
        ->getBody()
        ->withHeader('Access-Control-Allow-Origin', 'http://coderdojozh.github.io')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'POST,OPTIONS')
        ->write(true);
});

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
