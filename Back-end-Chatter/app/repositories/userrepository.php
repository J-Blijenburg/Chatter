<?php

namespace Repositories;

use Exception;
use PDO;
use PDOException;
use Repositories\Repository;
use Models\User;
use Models\Images;

class UserRepository extends Repository
{
    //check if the username and password are correct and return the user
    function checkUsernamePassword($username, $password)
    {
        // retrieve the user with the given username
        $stmt = $this->connection->prepare("SELECT id, username, password, email, imageId FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Models\User');
        $user = $stmt->fetch();

        //if there is no user with the given username, return a exception
        if (!$user) {
            throw new Exception("Invalid username", 401);
        }

        $this->verifyPassword($password, $user->password);

        return $user;
    }


    // verify the password hash with the given password
    function verifyPassword($input, $hash)
    {
        if (!password_verify($input, $hash)) {
            throw new Exception("Invalid password", 401);
        }
    }

    //insert the given user into the database
    function insert($user)
    {
        //check if the username or email already exists, if so throw an error
        $this->checkUsername($user->username);
        $this->checkEmail($user->email);

        //inser the user into the table users and return the user
        $stmt = $this->connection->prepare("INSERT into users (username, password, email, imageId) VALUES (?,?,?,?)");
        $stmt->execute([$user->username, $this->hashPassword($user->password), $user->email, 1]);
        $user->id = $this->connection->lastInsertId();

        //return the created user by first getting the user from the database by id
        return $this->getOne($user->id);
    }

    function checkUsername($username)
    {
        //check every username there is in the database and return true if the username is not in the database
        $stmt = $this->connection->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            throw new PDOException("Username already exists", 403);
        }
        return true;

    }

    function checkEmail($email)
    {
        //check every email there is in the database and return true if the email is not in the database
        $stmt = $this->connection->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            throw new PDOException("Email already exists", 403);
        }
        return true;

    }
    
    function hashPassword($password)
    {
        // hash the password (currently uses bcrypt)
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function getOne($id)
    {
        //get the user with the given id
        $query = "SELECT id, username, password, email, imageId FROM users WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        $user = $this->rowToUser($row);

        if ($stmt->rowCount() == 0) { 
            throw new PDOException("User not found", 404);
        }

        return $user;
    }

    function rowToUser($row)
    {
        //create a user object with the given row
        $user = new User();
        $user->id = $row['id'];
        $user->username = $row['username'];
        $user->password = $row['password'];
        $user->email = $row['email'];
        $user->imageId = $row['imageId'];
        return $user;
    }

    function delete($userId)
    {
        $stmt = $this->connection->prepare("DELETE FROM friends WHERE firstUser = :id OR secondUser = :id;
        DELETE FROM messages WHERE fromUser = :id OR toUser = :id;
        DELETE FROM users WHERE id = :id;");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    public function updateUsername($user)
    {
        if (!($this->checkUsername($user->username))) {
            throw new PDOException("Username already exists", 403);
        }
        $stmt = $this->connection->prepare("UPDATE users SET username = :username WHERE id = :id");
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':username', $user->username);
        $stmt->execute();
    }

    public function updateEmail($user)
    {
        if (!($this->checkEmail($user->email))) {
            throw new PDOException("Email already exists", 403);
        }
        $stmt = $this->connection->prepare("UPDATE users SET email = :email WHERE id = :id");
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':email', $user->email);
        $stmt->execute();
    }

    public function updatePassword($user)
    {
        try {
            $hashedPasword = $this->hashPassword($user->password);
            $stmt = $this->connection->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->bindParam(':id', $user->id);
            $stmt->bindParam(':password', $hashedPasword);
            $stmt->execute();


        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function uploadImage($targetFile)
    {
        try {

            $stmt = $this->connection->prepare("INSERT INTO images (images) VALUES (:image)");
            $stmt->bindParam(':image', $targetFile);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getProfileImage($userId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT IM.images FROM `users` AS US JOIN images AS IM ON US.imageId = IM.id WHERE US.id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            $image = $stmt->fetch();

            $extraImage = "data:image/jpeg;base64," . base64_encode($image['images']);
            return $extraImage;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function updateProfileImage($imageId, $userId)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET imageId = :imageId WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->bindParam(':imageId', $imageId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }
    }
}