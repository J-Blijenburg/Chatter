<?php
namespace Models;

class Message {

    public int $id;
    public int $fromUser;
    public int $toUser;
    public string $textMessage;
    public string $sendAt;
    public int $read;

}

?>