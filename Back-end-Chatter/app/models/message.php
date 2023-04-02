<?php
namespace Models;

class Message {

    public int $id;
    public User $fromUser;
    public User $toUser;
    public string $txtMessage;

    public string $sendAt;

}

?>