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
        
            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;

            $messages = $this->service->getMessagesById($jwtValues->id, $friendId);

            $this->respond($messages);
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }

        
    }

    public function createMessage(){
        try{
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;
            
            $message = $this->createObjectFromPostedJson("Models\\Message");

            $message->fromUser = $jwtValues->id;

            $message = $this->service->insert($message);

            $this->service->updateLastMessageId($message);

            $this->respond($message);
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }

    }
   
}