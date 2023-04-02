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
}

?>