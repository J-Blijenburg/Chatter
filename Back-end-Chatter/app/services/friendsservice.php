<?php
namespace Services;

use Repositories\FriendsRepository;

class FriendsService {

    private $repository;

    function __construct()
    {
        $this->repository = new FriendsRepository();
    }

    public function getFriendsByUserId($id) {
        return $this->repository->getFriendsByUserId($id);
    }

    public function getChatFriendsByUserId($id) {
        return $this->repository->getChatFriendsByUserId($id);
    }

    public function update($firstUser, $secondUser){
        return $this->repository->update($firstUser, $secondUser);
    }
}

?>