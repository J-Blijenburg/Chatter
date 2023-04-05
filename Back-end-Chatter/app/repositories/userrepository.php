<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;
use Models\User;
use Models\Images;

class UserRepository extends Repository
{
    function checkUsernamePassword($username, $password)
    {
        try {
            // retrieve the user with the given username
            $stmt = $this->connection->prepare("SELECT id, username, password, email, imageId FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
            $user = $stmt->fetch();

            if (!$user) {
                // user not found
                return false;
            }

            // verify if the password matches the hash in the database
            $stmt = $this->connection->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->bindParam(':id', $user->id);
            $stmt->execute();

            $hash = $stmt->fetchColumn();
            $result = $this->verifyPassword($password, $hash);

            if (!$result) {
                // password does not match
                return false;
            }

            return $user;
        } catch (PDOException $e) {
            throw new Exception("Error checking username and password: " . $e->getMessage());
        }
    }



    // verify the password hash
    function verifyPassword($input, $hash)
    {
        return password_verify($input, $hash);
    }

    function insert($user)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into users (username, password, email) VALUES (?,?,?)");

            $stmt->execute([$user->username, $this->hashPassword($user->password), $user->email]);

            $user->id = $this->connection->lastInsertId();

            return $this->getOne($user->id);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    // hash the password (currently uses bcrypt)
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    function getOne($id)
    {
        try {
            $query = "SELECT id, username, password, email, imageId FROM users WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch();
            $user = $this->rowToUser($row);

            return $user;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function rowToUser($row)
    {
        $user = new User();
        $user->id = $row['id'];
        $user->username = $row['username'];
        $user->password = $row['password'];
        $user->email = $row['email'];
        $user->imageId = $row['imageId'];
        return $user;
    }

    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT * FROM users";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset ";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\user');
            $users = $stmt->fetchAll();

            return $users;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($userId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM friends WHERE firstUser = :id OR secondUser = :id;
            DELETE FROM messages WHERE fromUser = :id OR toUser = :id;
            DELETE FROM users WHERE id = :id;");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updateProfileSettings($user)
    {
        try {
            $hashedPasword = $this->hashPassword($user->password);
            $stmt = $this->connection->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
            $stmt->bindParam(':id', $user->id);
            $stmt->bindParam(':username', $user->username);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':password', $hashedPasword);
            $stmt->execute();


        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function createImage($image)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO images (image) VALUES (:image)");
            $stmt->bindParam(':image', $image);
            $stmt->execute();
            $image = $this->connection->lastInsertId();
            return $image;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function setProfileImage($profileImage, $userId)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET profileImage = :profileImage WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->bindParam(':profileImage', $profileImage);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getProfileImage($imageId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT images FROM images WHERE id = :id");
            $stmt->bindParam(':id', $imageId);
            $stmt->execute();
            $image = $stmt->fetch();

            $extraImage = "data:image/jpeg;base64," . base64_encode($image['images']);
            return $extraImage;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}