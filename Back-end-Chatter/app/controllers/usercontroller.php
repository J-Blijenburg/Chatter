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

    public function login()
    {
        try {
            // Read the username and password from the body
            $postedUser = $this->createObjectFromPostedJson("Models\\User");

            // check if the username and password are correct
            $user = $this->service->checkUsernamePassword($postedUser->username, $postedUser->password);

            // generate jwt for the user
            $tokenResponse = $this->generateJwt($user);

            //respond with the created token and the user
            $this->respond($tokenResponse);
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }

    public function register()
    {
        try {
            //Read the username, password and email from the body
            $user = $this->createObjectFromPostedJson("Models\\User");

            //if the input is empty throw an error
            $this->checkInput($user);

            //insert the user in the database
            $user = $this->service->insert($user);

            $this->respond($user);
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }

    public function checkInput($input)
    {
        //check if input is not empty
        if (empty($input)) {
            throw new Exception("Input is empty", 400);
        }
    }

    public function getOneUser()
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;

            // Get the user with the id from the JWT
            $user = $this->service->getOne($jwtValues->id);

            $this->respond($user);
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }

    public function delete()
    {
        try {
            // Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();

            // Extract and return the values from the decoded JWT token
            $jwtValues = $token->data;

            $this->service->delete($jwtValues->id);
            $this->respond("User deleted");

        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }


    public function updateUsername()
    {
        //update the username of the user
        try {
            //get the username and id from the body
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->checkInput($user->username);
            $this->service->updateUsername($user);
            $this->respond("Username updated");
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }
    public function updateEmail()
    {
        //update the email of the user
        try {
            //get the email and id from the body
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->checkInput($user->email);
            $this->service->updateEmail($user);
            $this->respond("Email updated");
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }

    public function updatePassword()
    {
        //update the password of the user
        try {
            //get the password and id from the body
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->checkInput($user->password);
            $this->service->updatePassword($user);
            $this->respond("Password updated");
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }

    //return the profile image of the user
    public function getProfileImage()
    {
        try {
            //Checks for a valid jwt, returns 401 if none is found
            $token = $this->checkForJwt();

            $jwtValues = $token->data;

            $image = $this->service->getProfileImage($jwtValues->id);

            $this->respond($image);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function uploadImage()
    {
        //upload a image to the database
        try {
            header('Access-Control-Allow-Origin: *');

            //check if there is a file
            $this->checkForFile();

            //check if the file is valid
            $this->checkValidFile();

            $fileContent = file_get_contents($_FILES['file']['tmp_name']);

            $token = $this->checkForJwt();
            $jwtValues = $token->data;

            //upload the image to the database
            $imageId = $this->service->uploadImage($fileContent);

            //update the imageId of the user
            $this->service->updateProfileImage($imageId, $jwtValues->id);

            $this->respond("Image is succesfully uploaded with the id of $imageId");
        } catch (Exception $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        }
    }

    private function checkForFile(){
        if (!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
            throw new Exception("No file uploaded", 400);
        }
    }

    private function checkValidFile(){
        $allowed = array('png', 'jpg', 'pdf', 'jpeg');
        $fileName = $_FILES['file']['name'];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), $allowed)) {
            throw new Exception("File type not allowed", 400);
        }
    }



}