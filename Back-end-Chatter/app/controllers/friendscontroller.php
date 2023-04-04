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

    public function getFriendsByUserId()
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();
            if (!$token)
                return;

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;

            $friends = $this->service->getFriendsByUserId($jwtValues->id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($friends);
    }

    public function getChatFriendsByUserId()
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();
            if (!$token)
                return;

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;

            $friends = $this->service->getChatFriendsByUserId($jwtValues->id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($friends);
    }

    public function updateFriendsChatStatus($secondUser)
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();
            if (!$token)
                return;

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;

           
            $this->service->update($jwtValues->id, $secondUser);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

    }

    public function addFriend($friendId)
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();
            if (!$token)
                return;

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;
            

            $friends = $this->service->insert($jwtValues->id, $friendId);
            
            $this->respond($friends);


        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        
    }

    public function addRandomUser()
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();
            if (!$token)
                return;

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;
            
            $friends = $this->service->insertRandomFriendship($jwtValues->id);

            $this->respond($friends);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    
}