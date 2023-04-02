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

   
}