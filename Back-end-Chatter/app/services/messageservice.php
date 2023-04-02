<?php
namespace Services;

use Repositories\MessageRepository;

class MessageService {

    private $repository;

    function __construct()
    {
        $this->repository = new MessageRepository();
    }

    public function getMessagesById($currentUserId, $friendId) {
        return $this->repository->getMessagesById($currentUserId, $friendId);
    }
    
}

?>