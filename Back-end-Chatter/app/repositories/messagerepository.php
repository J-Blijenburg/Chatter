<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\Message;

class MessageRepository extends Repository
{
    public function getMessagesById($currentUserId, $friendId)
    {
        $stmt = $this->connection->prepare("SELECT fromUser, textMessage, sendAt FROM messages WHERE (fromUser = :currentUserId AND toUser = :friendId) OR (fromUser = :friendId AND toUser = :currentUserId)");
        $stmt->bindParam(':currentUserId', $currentUserId);
        $stmt->bindParam(':friendId', $friendId);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\Message');
        $messages = $stmt->fetchAll();
        return $messages;
    }

    function insert($message)
    {
        $stmt = $this->connection->prepare("INSERT into messages (fromUser, toUser, textMessage, sendAt) VALUES (?,?,?,?)");

        $stmt->execute([$message->fromUser, $message->toUser, $message->textMessage, $message->sendAt]);
        $message->id = $this->connection->lastInsertId();

        return $this->getOne($message->id);
    }

    function updateLastMessageId($message)
    {
        $stmt = $this->connection->prepare("UPDATE `friends` SET `lastMessageId` = :messageId WHERE (firstUser = :firstUser AND secondUser = :secondUser) OR (firstUser = :secondUser AND secondUser = :firstUser);");
        $stmt->bindParam(':messageId', $message->id);
        $stmt->bindParam(':firstUser', $message->fromUser);
        $stmt->bindParam(':secondUser', $message->toUser);
    }
    function getOne($id)
    {
        $query = "SELECT id, fromUser, toUser, textMessage, sendAt FROM messages WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        $user = $this->rowToUser($row);

        return $user;
    }
    function rowToUser($row)
    {
        $message = new Message();
        $message->id = $row['id'];
        $message->fromUser = $row['fromUser'];
        $message->toUser = $row['toUser'];
        $message->textMessage = $row['textMessage'];
        $message->sendAt = $row['sendAt'];

        return $message;
    }



}