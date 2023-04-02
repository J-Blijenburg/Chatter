<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\Friends;

class FriendsRepository extends Repository
{
    public function getFriendsByUserId($id){
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

    
}
