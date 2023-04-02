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

    public function getMessagesById($currentUserId, $friendId){
        try {
            $messages = $this->service->getMessagesById($currentUserId, $friendId);
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