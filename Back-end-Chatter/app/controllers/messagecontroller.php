<?php

namespace Controllers;

use Exception;
use Services\MessageService;
use \Firebase\JWT\JWT;

class MessageController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new MessageService();
    }

    public function getMessagesById($friendId){
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();
            if (!$token)
                return;

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;

            $messages = $this->service->getMessagesById($jwtValues->id, $friendId);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($messages);
    }

    public function createMessage(){
        try{
            $message = $this->createObjectFromPostedJson("Models\\Message");
            $message = $this->service->insert($message);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

    }
   
}