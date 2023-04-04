<?php

namespace reunionou\actions;

use reunionou\services\ParticipantService;
use reunionou\services\UserService;
use reunionou\services\EventService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


final class inviteParticipantAction
{
    public function __invoke(Request $request, Response $response, mixed $args): Response
    {

        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);

        try {
            $decoded = JWT::decode($token, new Key('63DDF4E66BEC66FAA5B66D87989B6', 'HS256'));
            $user_id = $decoded->user_id;
        } catch (\Exception $e) {
            return $response->withStatus(401);
        }

        $data = $request->getParsedBody();
        $event_id = $args['id'];
        $email = $data['email'] ?? null;

        $event = EventService::getEventById($event_id);

        if ($user_id !== $event['organizer_id']){
            $response = $response->withStatus(401)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode([
                'error' => 'You are not the creator of the event'
            ]));
            return $response;
        }

        if (!$email){
            $response = $response->withStatus(401)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode([
                'error' => 'Ymissing required fields'
            ]));
            return $response;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = $response->withStatus(401)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode([
                'error' => 'Invalide email address'
            ]));
            return $response;
        }

        $user = UserService::getUserByEmail($email);

        $comment = ParticipantService::inviteParticipant($event_id, $user['id'], $user['firstname'], $user['lastname'], $email, 'pending');
        
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($comment));

        return $response;
    }
}