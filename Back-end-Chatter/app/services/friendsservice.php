<?php
namespace Services;

use Repositories\FriendsRepository;

class FriendsService
{

    private $repository;

    function __construct()
    {
        $this->repository = new FriendsRepository();
    }

    public function getFriendsByUserId($id)
    {
        return $this->repository->getFriendsByUserId($id);
    }

    public function getChatFriendsByUserId($userId)
    {
        return $this->repository->getChatFriendsByUserId($userId);
    }

    public function update($firstUser, $secondUser)
    {
        return $this->repository->update($firstUser, $secondUser);
    }

    public function insert($firstUser, $secondUser)
    {
        return $this->repository->insert($firstUser, $secondUser);
    }

    //get the friendId from the repository and return it to the controller
    public function getFriendIdByUsername($friendUsername)
    {
        return $this->repository->getFriendIdByUsername($friendUsername);
    }

    public function insertRandomFriendship($userId)
    {
       return $this->repository->insertRandomFriendship($userId);
    }

    public function getProfileImagesByFriendId($friendId){
        return $this->repository->getProfileImagesByFriendId($friendId);
    }

    //remove the friendship between the two users
    public function removeFriendship($userId, $friendId){
        $this->repository->removeFriendship($userId, $friendId);
    }
}

?>