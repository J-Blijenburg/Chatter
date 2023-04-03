<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\Friends;

class FriendsRepository extends Repository
{
    public function getFriendsByUserId($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT US.id, US.username, US.email 
            FROM friends AS FR 
            JOIN users AS US ON FR.firstUser = US.id OR FR.secondUser = US.id
            WHERE (FR.firstUser = :id OR FR.secondUser = :id) AND US.id <> :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $friends = $stmt->fetchAll();
            return $friends;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getChatFriendsByUserId($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT US.id, US.username, US.email 
            FROM friends AS FR 
            JOIN users AS US ON FR.firstUser = US.id OR FR.secondUser = US.id
            WHERE (FR.firstUser = :id OR FR.secondUser = :id) AND US.id <> :id AND FR.activeChat = 1");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\\User');
            $friends = $stmt->fetchAll();
            return $friends;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function update($firstUser, $secondUser)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE friends SET activeChat = 1 WHERE (firstUser = :firstUser AND secondUser = :secondUser) OR (firstUser = :secondUser AND secondUser = :firstUser)");
            $stmt->bindParam(':firstUser', $firstUser);
            $stmt->bindParam(':secondUser', $secondUser);
            $stmt->execute();

        } catch (PDOException $e) {
            echo $e;
        }
    }

    function insert($friends)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into friends (firstUser, secondUser, activeChat) VALUES (:firstUser,:secondUser,0)");
            $stmt->bindParam(':firstUser', $friends->firstUser);
            $stmt->bindParam(':secondUser', $friends->secondUser);
            $stmt->execute();
            $friends->id = $this->connection->lastInsertId();

            return $this->getOne($friends->id);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function insertRandomFriendship($friendship)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into friends (firstUser, secondUser, activeChat) VALUES (:firstUser,:secondUser,0)");
            $stmt->bindParam(':firstUser', $friendship->firstUser);

            $randomUserId = $this->getRandomUserId($friendship);

            $stmt->bindParam(':secondUser', $randomUserId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function getRandomUserId($friendship)
    {
        try {
            $stmt = $this->connection->prepare("SELECT id FROM users
            WHERE id <> :id
            AND NOT EXISTS (
                SELECT * FROM friends
                WHERE (firstUser = :id AND secondUser = users.id)
                OR (secondUser = :id AND firstUser = users.id)
            )
            ORDER BY RAND() LIMIT 1");
            $stmt->bindParam(':id', $friendship->firstUser);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            return $row['id'];
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getOne($id)
    {
        try {
            $query = "SELECT id, firstUser, secondUser, activeChat FROM friends WHERE  id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $product = $this->rowToProduct($row);

            return $product;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    function rowToProduct($row)
    {
        $friends = new Friends();
        $friends->id = $row['id'];
        $friends->firstUser = $row['firstUser'];
        $friends->secondUser = $row['secondUser'];
        $friends->activeChat = $row['activeChat'];
        return $friends;
    }


}