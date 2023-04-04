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

    public function insertRandomFriendship($userId)
    {
       return $this->repository->insertRandomFriendship($userId);
    }
}

?>