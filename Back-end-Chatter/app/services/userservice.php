<?php
namespace Services;

use Repositories\UserRepository;

class UserService {

    private $repository;

    function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function checkUsernamePassword($username, $password) {
        return $this->repository->checkUsernamePassword($username, $password);
    }

    //insert into users to create a new user
    public function insert($user) {       
        return $this->repository->insert($user);        
    }

    public function getAll($offset = NULL, $limit = NULL) {
        return $this->repository->getAll($offset, $limit);
    }

    public function getOne($id) {
        return $this->repository->getOne($id);
    }

    public function delete($userId){
        $this->repository->delete($userId);
    }

    public function updateUsername($user) {
        $this->repository->updateUsername($user);
    }

    public function createImage($image){
        return $this->repository->createImage($image);
    }

    public function setProfileImage($profileImage, $userId) {
        $this->repository->setProfileImage($profileImage, $userId);
    }

    public function getProfileImage($userId){
        return $this->repository->getProfileImage($userId);
    }
}

?>