<?php

namespace Controllers;

use Exception;
use Services\UserService;
use \Firebase\JWT\JWT;
use Models\User;

class UserController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new UserService();
    }

    public function create()
    {
        try {
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->checkInput($user);
            $user = $this->service->insert($user);
            $this->respond($user);
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }


    }

    public function login()
    {

        // read user data from request body
        $postedUser = $this->createObjectFromPostedJson("Models\\User");

        // get user from db
        $user = $this->service->checkUsernamePassword($postedUser->username, $postedUser->password);

        // if the method returned false, the username and/or password were incorrect
        if (!$user) {
            $this->respondWithError(401, "Invalid login");
            return;
        }

        // generate jwt
        $tokenResponse = $this->generateJwt($user);

        $this->respond($tokenResponse);
    }

    public function generateJwt($user)
    {
        $secret_key = "YOUR_SECRET_KEY";

        $issuer = "THE_ISSUER"; // this can be the domain/servername that issues the token
        $audience = "THE_AUDIENCE"; // this can be the domain/servername that checks the token

        $issuedAt = time(); // issued at
        $notbefore = $issuedAt; //not valid before 


        //I have set the expiration time to 24 hours since i had no time to implement the refresh token.

        $expire = $issuedAt + 60 * 60 * 24;
        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            "exp" => $expire,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email,
                "imageId" => $user->imageId
            )
        );

        $jwt = JWT::encode($payload, $secret_key, 'HS256');

        return
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "username" => $user->username,
                "expireAt" => $expire
            );
    }

    //get all the users there are
    public function getAll()
    {
        // Checks for a valid jwt, returns 401 if none is found
        $token = $this->checkForJwt();
        if (!$token)
            return;

        $offset = NULL;
        $limit = NULL;


        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $users = $this->service->getAll($offset, $limit);

        $this->respond($users);
    }

    //get a single user
    public function getOne($id)
    {
        $user = $this->service->getOne($id);

        // we might need some kind of error checking that returns a 404 if the product is not found in the DB
        if (!$user) {
            $this->respondWithError(404, "User not found");
            return;
        }

        $this->respond($user);
    }



    public function getOneUser()
    {
        // Checks for a valid jwt, returns 401 if none is found
        $token = $this->checkForJwt();
        if (!$token)
            return;

        // Extract and return the values from the decoded JWT token
        $jwtValues = $token->data;

        // Get the user with the id from the JWT
        $user = $this->service->getOne($jwtValues->id);

        if (!$user) {
            $this->respondWithError(404, "User not found");
            return;
        }

        $this->respond($user);
    }

    public function delete()
    {
        // Checks for a valid jwt, returns 401 if none is found
        $token = $this->checkForJwt();
        if (!$token)
            return;

        // Extract and return the values from the decoded JWT token
        $jwtValues = $token->data;

        $this->service->delete($jwtValues->id);
        return $this->respond("User deleted");
    }

    //update the username of the user
    public function updateUsername()
    {
        try {
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->checkInput($user->username);
            $this->service->updateUsername($user);
            $this->respond("User updated");
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }
    public function updateEmail()
    {
        try {
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->checkInput($user->email);
            $this->service->updateEmail($user);
            $this->respond("User updated");
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }



    public function updatePassword()
    {
        try {
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->checkInput($user->password);
            $this->service->updatePassword($user);
            $this->respond("User updated");
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }

    //check if input is not empty
    public function checkInput($input)
    {
        if (empty($input)) {
            throw new Exception("Input is empty", 400);
        }
    }


    //return the profile image of the user
    public function getProfileImage()
    {
        try {
            //Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();
            if (!$token)
                return;

            $jwtValues = $token->data;

            $image = $this->service->getProfileImage($jwtValues->id);

            $this->respond($image);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }


    public function updateProfileImage()
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found

            $image = $this->createObjectFromPostedFile("Models\\Image", 'image');

            if ($image == null) {
                $this->respondWithError(500, "No image found");
            } else {
                // $encodedImage = base64_encode($image);

                // $this->service->updateProfileImage($encodedImage, $jwtValues->id);

                $this->respond('Profile image updated successfully');
            }
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }



    public function uploadImage()
    {
        header('Access-Control-Allow-Origin: *');

        if (!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $this->respondWithError(400, "No file uploaded");
            return;
        }

        $allowed = array('png', 'jpg', 'pdf', 'jpeg');
        $fileName = $_FILES['file']['name'];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), $allowed)) {
            $this->respondWithError(400, "File type not allowed");
            return;
        }

        // $targetFile = 'upload/' . basename();
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);

        $imageId = $this->service->uploadImage($fileContent);

        $token = $this->checkForJwt();
        if (!$token)
            return;

        $jwtValues = $token->data;

        $this->service->updateProfileImage($imageId, $jwtValues->id);

        $this->respond('Profile image updated successfully');
    }



}