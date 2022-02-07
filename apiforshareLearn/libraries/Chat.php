<?php

class Chat
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getAllMessages($sender, $receiver)
    {

        // $this->db->query("SELECT * FROM chat WHERE outgoingId = :sender AND incomingId = :receiver OR outgoingId = :receiver AND incomingId = :sender ORDER BY id ASC");
        // $this->db->query("SELECT * FROM chat
        // INNER JOIN user.picture ON chat.outgoingId = user.id
        // WHERE (outgoingId = :sender AND incomingid = :receiver)
        // OR (outgoingId = :receiver AND incomingId = :sender)
        // ORDER BY chat.id");

        // $this->db->query("SELECT chat.*, user.picture FROM chat
        // INNER JOIN user ON chat.outgoingId = user.id
        // WHERE (outgoingId = :sender AND incomingid = :receiver)
        // OR (outgoingId = :receiver AND incomingId = :sender)
        // ORDER BY chat.id");

        $this->db->query("SELECT chat.*, user.* FROM chat
        INNER JOIN user ON chat.outgoingId = user.id
        WHERE (outgoingId = :sender AND incomingId = :receiver)
        OR (outgoingId = :receiver AND incomingId = :sender)
        ORDER BY chat.id");

        $this->db->bind(':sender', $sender);
        $this->db->bind(':receiver', $receiver);

        $rows = $this->db->resultset();
        return $rows;
    }

    public function getMessage($sender, $receiver)
    {
    
            // $this->db->query("SELECT * FROM chat WHERE outgoingId = :sender AND incomingId = :receiver OR outgoingId = :receiver AND incomingId = :sender ORDER BY id DESC");
            $this->db->query("SELECT chat.*, user.* FROM chat
        INNER JOIN user ON chat.outgoingId = user.id
        WHERE (outgoingId = :sender AND incomingId = :receiver)
        OR (outgoingId = :receiver AND incomingId = :sender)
        ORDER BY chat.id LIMIT 1");
            $this->db->bind(':sender', $sender);
            $this->db->bind(':receiver', $receiver);
    
            $row = $this->db->single();
    
            return $row;
    }


    public function sendMessage($sender, $receiver, $message)
    {
        $this->db->query("INSERT INTO chat (outgoingId, incomingId, message) VALUES (:sender, :receiver, :message)");
        $this->db->bind(':sender', $sender);
        $this->db->bind(':receiver', $receiver);
        $this->db->bind(':message', $message);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }












}
