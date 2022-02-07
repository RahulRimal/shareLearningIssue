<?php

class ChatException extends Exception
{
}

class Chat
{

    private $db;


    private $id;
    private $incomingId;
    private $outgoingId;
    private $message;
    private $messageSentDate;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIncomingId()
    {
        return $this->incomingId;
    }

    public function getOutgoingId()
    {
        return $this->outgoingId;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getMessageSentDate()
    {
        return $this->messageSentDate;
    }


    public function setId($id)
    {
        if (is_null($id))
            throw new ChatException('Chat ID can\'t be null');
        elseif (empty($id))
            throw new ChatException('Chat ID can\'t be empty');
        elseif (!is_numeric($id))
            throw new ChatException('Chat ID must be a number');
        else
            $this->id = $id;
    }

    public function setIncomingId($incomingId)
    {
        if (is_null($incomingId))
            throw new ChatException('Incoming ID can\'t be null');
        elseif (empty($incomingId))
            throw new ChatException('Incoming ID can\'t be empty');
        elseif (!is_numeric($incomingId))
            throw new ChatException('Incoming ID must be a number');
        else
            $this->incomingId = $incomingId;
    }

    public function setOutgoingId($outgoingId)
    {
        if (is_null($outgoingId))
            throw new ChatException('Outgoing ID can\'t be null');
        elseif (empty($outgoingId))
            throw new ChatException('Outgoing ID can\'t be empty');
        elseif (!is_numeric($outgoingId))
            throw new ChatException('Outgoing ID must be a number');
        else
            $this->outgoingId = $outgoingId;
    }

    public function setMessage($message)
    {
        if (empty($message))
            throw new ChatException('Message can\'t be empty');
        else
            $this->message = $message;
    }

    public function setMessageSentDate($messageSentDate)
    {
        if (empty($messageSentDate))
            throw new ChatException('Message sent date can\'t be empty');
        else
            $this->messageSentDate = $messageSentDate;
    }

    public function setChatFromRow($row)
    {
        $this->setId($row->id);
        $this->setIncomingId($row->incomingId);
        $this->setOutgoingId($row->outgoingId);
        $this->setMessage($row->message);
        $this->setMessageSentDate($row->messageSentDate);
    }

    public function setChatFromArray($data)
    {
        isset($data['id']) ? $this->setId($data['id']) : false;
        isset($data['incomingId']) ? $this->setIncomingId($data['incomingId']) : false;
        isset($data['outgoingId']) ? $this->setOutgoingId($data['outgoingId']) : false;
        isset($data['message']) ? $this->setMessage($data['message']) : false;
        isset($data['messageSentDate']) ? $this->setMessageSentDate($data['messageSentDate']) : false;
    }

    public function returnChatAsArray()
    {
        $chat = array();

        $chat['id'] = $this->id;
        $chat['incomingId'] = $this->incomingId;
        $chat['outgoingId'] = $this->outgoingId;
        $chat['message'] = $this->message;
        $chat['messageSentDate'] = $this->messageSentDate;

        return $chat;
    }

    public function messageExists($outgoing, $incoming, $message)
    {
        try {
            $this->setOutgoingId(intval($outgoing));
            $this->setIncomingId(intval($incoming));
            $this->setMessage($message);

            $this->db->query('SELECT * FROM chat WHERE (outgoingId = :outgoingId AND incomingId = :incomingId)
            OR (incomingId = :outgoingId AND outgoingId = :incomingId) AND message = :message');

            $this->db->bind(":outgoingId", $this->outgoingId);
            $this->db->bind(":incomingId", $this->incomingId);
            $this->db->bind(":message", $this->message);

            $row = $this->db->single();

            if ($row)
                return true;
            else
                return false;
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun messageExists: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function chatMessageExists($id, $sender = null, $receiver = null)
    {
        try {

            $this->setId($id);

            if (is_null($sender) || is_null($receiver)) {
                $this->db->query('SELECT * FROM chat where id = :chat');
                $this->db->bind(':chat', $this->id);
            } elseif (!is_null($sender) && !is_null($receiver)) {

                $this->setOutgoingId($sender);
                $this->setIncomingId($receiver);
                $this->db->query(
                    "SELECT chat.*, user.* FROM chat
                                INNER JOIN user ON chat.outgoingId = user.id
                                WHERE (id = :chatId outgoingId = :sender AND incomingId = :receiver)
                                OR (id = :chatId outgoingId = :receiver AND incomingId = :sender)
                                ORDER BY chat.id"
                );

                $this->db->bind(':chatId', $this->id);
                $this->db->bind(':sender', $this->outgoingId);
                $this->db->bind(':receiver', $this->incomingId);
            } else {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
            $row = $this->db->single();

            // if ($row->totalCount > 0)
            //     return true;

            if ($this->db->rowCount() > 0)
                return true;

            return false;
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun chatMessageExists: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getMessageById($id, $sendAsResponse = true)
    {
        try {
            
            $this->setId(intval($id));

            $this->db->query("SELECT * FROM chat WHERE id = :id");

            $this->db->bind(":id", $this->id);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {

                $this->setChatFromRow($row);

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['chats'] = $this->returnChatAsArray();

                if($sendAsResponse)
                {
                    $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Chat retrievd successfully');
                $response->setData($returnData);
                return $response;
                }
                else
                {
                    return $row;
                }
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve messages, please try again');
                $response->send();
                exit;
            }
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getMessageById: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getSingleMessage($sender, $receiver, $sendAsResponse = true)
    {

        try {
            $this->setOutgoingId(intval($sender));
        $this->setIncomingId(intval($receiver));

            $this->db->query("SELECT chat.*, user.* FROM chat
        INNER JOIN user ON chat.outgoingId = user.id
        WHERE (outgoingId = :sender AND incomingId = :receiver)
        OR (outgoingId = :receiver AND incomingId = :sender)
        ORDER BY chat.id");

            $this->db->bind(':sender', $this->outgoingId);
            $this->db->bind(':receiver', $this->incomingId);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0) {

                $this->setChatFromRow($row);

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['chats'] = $this->returnChatAsArray();

                if($sendAsResponse)
                {
                    $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Chat retrievd successfully');
                $response->setData($returnData);
                return $response;
                }
                else
                {
                    return $row;
                }
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve messages, please try again');
                $response->send();
                exit;
            }
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getSingleMessage: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getAllMessages($sender, $receiver)
    {
        $this->setOutgoingId(intval($sender));
        $this->setIncomingId(intval($receiver));

        try {

            $this->db->query("SELECT chat.*, user.* FROM chat
        INNER JOIN user ON chat.outgoingId = user.id
        WHERE (outgoingId = :sender AND incomingId = :receiver)
        OR (outgoingId = :receiver AND incomingId = :sender)
        ORDER BY chat.id");

            $this->db->bind(':sender', $this->outgoingId);
            $this->db->bind(':receiver', $this->incomingId);

            $rows = $this->db->resultset();
            // return $rows;

            if ($this->db->rowCount() > 0) {

                $chatArray = array();

                foreach ($rows as $row) {
                    $this->setChatFromRow($row);

                    $chatArray[] = $this->returnChatAsArray();
                }

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['chats'] = $chatArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Chats retrievd successfully');
                $response->setData($returnData);
                return $response;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve messages, please try again');
                $response->send();
                exit;
            }
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getAllMessages: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getAMessage($sender, $receiver)
    {

        $this->setOutgoingId(intval($sender));
        $this->setIncomingId(intval($receiver));

        try {

            $this->db->query("SELECT chat.*, user.* FROM chat
        INNER JOIN user ON chat.outgoingId = user.id
        WHERE (outgoingId = :sender AND incomingId = :receiver)
        OR (outgoingId = :receiver AND incomingId = :sender)
        ORDER BY chat.id DESC LIMIT 2");

            $this->db->bind(':sender', $this->outgoingId);
            $this->db->bind(':receiver', $this->incomingId);

            $rows = $this->db->resultset();

            if ($this->db->rowCount() > 0) {

                $chatArray = array();

                foreach ($rows as $row) {
                    $this->setChatFromRow($row);

                    $chatArray[] = $this->returnChatAsArray();
                }

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['chats'] = $chatArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Chat retrievd successfully');
                $response->setData($returnData);
                return $response;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve messages, please try again');
                $response->send();
                exit;
            }
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getAMessage: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }


    public function sendMessage($sender, $receiver, $message)
    {

        try {

            $this->setOutgoingId(intval($sender));
            $this->setIncomingId(intval($receiver));
            $this->setMessage($message);

            $this->db->query("INSERT INTO chat (outgoingId, incomingId, message) VALUES (:sender, :receiver, :message)");
            $this->db->bind(':sender', $this->outgoingId);
            $this->db->bind(':receiver', $this->incomingId);
            $this->db->bind(':message', $this->message);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun sendMessage: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function createMessage($outgoingId, $incomingId, $data)
    {

        try {
            // $this->setIncomingId(intval($incomingId));
            // $this->setOutgoingId(intval($outgoingId));

            $data['messageSentDate'] = date("Y-m-d H:i:s");

            $this->setChatFromArray($data);

            if ($this->messageExists($this->outgoingId, $this->incomingId, $this->message)) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Message already posted");
                $response->send();
                exit;
            }

            $this->db->query('INSERT INTO chat (id, incomingId, outgoingId, message, messageSentDate) VALUES (null, :incomingId, :outgoingId, :message, null)');

            $this->db->bind(':incomingId', $this->incomingId);
            $this->db->bind(':outgoingId', $this->outgoingId);
            $this->db->bind(':message', $this->message);

            if ($this->db->execute()) {
                $messageId = $this->db->lastInsertId();
                $this->setId($messageId);

                if (is_null($this->id)) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't get message after posting it");
                    $response->send();
                    exit;
                }

                $this->db->query('SELECT * FROM  chat where id = :chatId');
                $this->db->bind(":chatId", $this->id);

                $row = $this->db->single();

                if ($this->db->rowCount() < 1) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't get message after posting it");
                    $response->send();
                    exit;
                }

                $this->setChatFromRow($row);

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['chats'] = $this->returnChatAsArray();

                $response = new Response();
                $response->setHttpStatusCode(201);
                $response->setSuccess(true);
                $response->addMessage("Message posted successfully");
                $response->setData($returnData);
                return $response;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Error posting the message, please try again");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun createMessage: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function updateMessage($id, $data)
    {
        try {
            $this->setId(intval($id));

            $this->setChatFromArray($data);

            if (!$this->chatMessageExists($this->id, $this->outgoingId, $this->incomingId)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find a message to update");
                $response->send();
                exit;
            }

            $outgoingIdUpdated = false;
            $incomingIdUpdated = false;
            $messageBodyUpdated = false;
            $messageSentDateUpdated = false;

            $queryFields = "";

            $this->db->query('SELECT * FROM chat where id = :chatId');
            $this->db->bind(":chatId", $this->id);

            $row = $this->db->single();

            $this->setChatFromRow($row);

            if (array_key_exists('outgoingId', $data)) {
                if (!is_null($this->outgoingId)) {
                    if ((strcmp($data["outgoingId"], $this->outgoingId)) != 0) {
                        $outgoingIdUpdated = true;
                        $this->setOutgoingId($data['outgoingId']);
                        $queryFields .= "outgoingId = :outgoingId, ";
                    }
                }
                
            }

            if (array_key_exists('incomingId', $data)) {
                    if ((strcmp($data["incomingId"], $this->incomingId)) != 0) {
                        $incomingIdUpdated = true;
                        $this->setIncomingId($data['incomingId']);
                        $queryFields .= "incomingId = :incomingId, ";
                    }
                
            }

            if (array_key_exists('message', $data)) {
                if ((strcmp($data["message"], $this->message)) != 0) {
                    $messageBodyUpdated = true;
                    $this->setMessage($data['message']);
                    $queryFields .= "message = :message, ";
                }
            }

            if (array_key_exists('messageSentDate', $data)) {
                if ((strcmp($data["messageSentDate"], $this->messageSentDate)) != 0) {
                    $messageSentDateUpdated = true;
                    $this->setMessageSentDate($data['messageSentDate']);
                    $queryFields .= "messageSentDate = :messageSentDate, ";
                }
            }

            $queryFields = rtrim($queryFields, ", ");

            if (!$outgoingIdUpdated && !$incomingIdUpdated && !$messageBodyUpdated && !$messageSentDateUpdated) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("No new information to update");
                $response->send();
                exit;
            }

            $this->db->query("UPDATE chat SET " . $queryFields . " WHERE id = :chatId");
            $this->db->bind(':chatId', $this->id);

            if ($incomingIdUpdated)
                $this->db->bind(":incomingId", $this->incomingId);

            if ($outgoingIdUpdated)
                $this->db->bind(":outgoingId", $this->outgoingId);

            if ($messageBodyUpdated)
                $this->db->bind(":message", $this->message);

            if ($messageSentDateUpdated)
                $this->db->bind(":messageSentDate", $this->messageSentDate);


            $this->db->execute();

            if ($this->db->rowCount() > 0) {

                $row = $this->getMessageById($this->id, false);

                $this->setChatFromRow($row);

                $returnData = array();

                $returnData["rows_returned"] = $this->db->rowCount();
                $returnData["posts"] = $this->returnChatAsArray();

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Message Information Updated successfully");
                $response->setData($returnData);
                return $response;
                // $response->send();
                // exit;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Something went wrong, please try again");
                $response->send();
                exit;
            }
        } catch (PostException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun updateMessage: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function deleteMessage($chat)
    {

        try {
            $this->setId(intval($chat));

            if (!$this->chatMessageExists($this->id)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the message to delete");
                $response->send();
                exit;
            }

            $this->db->query("DELETE FROM chat WHERE id = :chat");
            $this->db->bind(':chat', $this->id);

            if ($this->db->execute()) {
                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Chat Message Deleted Successfully");
                return $response;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Couldn't delete the chat message");
                $response->send();
                exit;
            }
        } catch (ChatException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun deleteMessage: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

}
