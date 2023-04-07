<?php
namespace Models;

class Friends {

    public int $id;
    public User $firstUser;
    public User $secondUser;
    public int $activeChat;
    public int $lastMessageId;
}

?>