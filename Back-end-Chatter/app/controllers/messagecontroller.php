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
   
}