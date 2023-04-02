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
}