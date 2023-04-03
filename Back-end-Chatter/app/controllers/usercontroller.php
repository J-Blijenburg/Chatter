<?php

namespace Controllers;

use Exception;
use Services\UserService;
use \Firebase\JWT\JWT;

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
            $user = $this->service->insert($user);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($user);
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
        $expire = $issuedAt + 6000; // expiration time is set at +600 seconds (10 minutes)

        // JWT expiration times should be kept short (10-30 minutes)
        // A refresh token system should be implemented if we want clients to stay logged in for longer periods

        // note how these claims are 3 characters long to keep the JWT as small as possible
        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issuedAt,
            "nbf" => $notbefore,
            "exp" => $expire,
            "data" => array(
                "id" => $user->id,
                "username" => $user->username,
                "email" => $user->email
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

        // Merge the JWT values with the user data and send the response
        $response = array(
            "data" => $user
        );
        $this->respond($response);
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
        return$this->respond("User deleted");
    }
}