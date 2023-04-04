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

    public function insert($item) {       
        return $this->repository->insert($item);        
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

    public function updateProfileSettings($user) {
        $this->repository->updateProfileSettings($user);
    }

    public function createImage($image){
        return $this->repository->createImage($image);
    }

    public function setProfileImage($createdImageId, $userId) {
        $this->repository->setProfileImage($createdImageId, $userId);
    }
}

?>