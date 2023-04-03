<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');


// routes for the users endpoint
$router->post('/users/login', 'UserController@login');
$router->post('/users/register', 'UserController@create');
$router->get('/users/getOneUser', 'UserController@getOneUser');
$router->get('/users/getOneUser', 'UserController@getOneUser');
$router->delete('/users/removeUser', 'UserController@delete');
$router->put('/users/changeProfileSettings', 'UserController@updateProfileSettings');

// routes for the friends endpoint
$router->get('/friends/getFriendsByUserId', 'FriendsController@getFriendsByUserId');
$router->get('/friends/getChatFriendsByUserId', 'FriendsController@getChatFriendsByUserId');
$router->put('/friends/startChat/(\d+)', 'FriendsController@updateFriendsChatStatus');
$router->post('/friends/addFriend/(\d+)', 'FriendsController@addFriend');
$router->post('/friends/addRandomUser', 'FriendsController@addRandomUser');

//routes for the messages endpoint
$router->get('/messages/getMessagesById/(\d+)', 'MessageController@getMessagesById');
$router->post('/messages/createMessage', 'MessageController@createMessage');

// Run it!
$router->run();