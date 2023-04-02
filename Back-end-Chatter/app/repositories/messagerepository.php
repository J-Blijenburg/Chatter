<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\Message;

class MessageRepository extends Repository
{
    public function getMessagesById($currentUserId, $friendId) {
        $sql = "SELECT * FROM messages WHERE (from_user_id = :currentUserId AND to_user_id = :friendId) OR (from_user_id = :friendId AND to_user_id = :currentUserId) ORDER BY send_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':currentUserId', $currentUserId);
        $stmt->bindParam(':friendId', $friendId);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_CLASS, Message::class);
        return $messages;
    }

    
}
