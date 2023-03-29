<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;
use reunionou\services\UserService;
use Illuminate\Database\Capsule\Manager as DB;
use Psr\Container\ContainerInterface;
use DI\Container;

use reunionou\actions\GetUserAction;
use reunionou\actions\GetEventParticipantsAction;
use reunionou\actions\GetEventAction;
use reunionou\actions\GetEventsAction;
use reunionou\actions\GetCommentsByEventIdAction;
use reunionou\actions\RegisterUserAction;
use reunionou\actions\LoginUserAction;
use reunionou\actions\AddCommentAction;

$db = new DB();
$db->addConnection([
    'driver' => 'mysql',
    'host' => 'mysql',
    'database' => 'atelier2',
    'username' => 'atelier2',
    'password' => 'atelier2',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);


$db->setAsGlobal();
$db->bootEloquent();

$app = AppFactory::create();


$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, false, false);

$app->post('/register', RegisterUserAction::class);//
$app->post('/login', LoginUserAction::class);//
$app->get('/user/{id}', GetUserAction::class); //
$app->post('/event', CreateEventAction::class);
$app->get('/event/{id}', GetEventAction::class);//
$app->get('/events', GetEventsAction::class);//
$app->put('/event/{id}', UpdateEventAction::class);
$app->delete('/event/{id}', DeleteEventAction::class);
$app->post('/event/{id}/invite', InviteParticipantAction::class);
$app->get('/event/{id}/participants', GetEventParticipantsAction::class);//
$app->put('/participant/{id}/status', UpdateParticipantStatusAction::class);
$app->post('/event/{id}/comment', AddCommentAction::class);//
$app->get('/event/{id}/comments', GetCommentsByEventIdAction::class);//

$app->run();