<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\Message;

class MessageRepository extends Repository
{
    public function getMessagesById($currentUserId, $friendId) {
        try {
            $stmt = $this->connection->prepare("SELECT fromUser, textMessage FROM messages WHERE (fromUser = :currentUserId AND toUser = :friendId) OR (fromUser = :friendId AND toUser = :currentUserId)");
            $stmt->bindParam(':currentUserId', $currentUserId);
            $stmt->bindParam(':friendId', $friendId);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Message');
            $messages = $stmt->fetchAll();
            return $messages;
        } catch (PDOException $e) {
            echo $e;
        }
    }

   
    
}
