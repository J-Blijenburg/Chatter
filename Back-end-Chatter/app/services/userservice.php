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

    public function insert($user) {       
        return $this->repository->insert($user);        
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

    public function updateEmail($user) {
        $this->repository->updateEmail($user);
    }

    public function updatePassword($user) {
        $this->repository->updatePassword($user);
    }

    public function getProfileImage($userId){
        return $this->repository->getProfileImage($userId);
    }

    public function uploadImage($targetFile){
       return $this->repository->uploadImage($targetFile);
    }

    public function updateProfileImage($imageId, $userId){
        $this->repository->updateProfileImage($imageId, $userId);
    }
}

?>