<?php

namespace Controllers;

use Exception;
use Services\FriendsService;
use \Firebase\JWT\JWT;

class friendsController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new FriendsService();
    }

    public function getFriendsByUserId($id)
    {
        try {
            $friends = $this->service->getFriendsByUserId($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($friends);
    }

    public function getChatFriendsByUserId($id){
        try {
            $friends = $this->service->getChatFriendsByUserId($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($friends);
    }

    public function updateFriendsChatStatus($firstUser, $secondUser){
        try{
            $this->service->update($firstUser, $secondUser);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
        
    }
}