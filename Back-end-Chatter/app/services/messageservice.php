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
    public function insert($message) {       
        return $this->repository->insert($message);        
    }

    public function updateLastMessageId($message){
        $this->repository->updateLastMessageId($message);
    }
    
}

?>