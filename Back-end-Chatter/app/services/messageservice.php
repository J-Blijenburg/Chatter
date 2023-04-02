<?php
namespace Services;

use Repositories\MessageRepository;

class FriendsService {

    private $repository;

    function __construct()
    {
        $this->repository = new MessageRepository();
    }

    
}

?>