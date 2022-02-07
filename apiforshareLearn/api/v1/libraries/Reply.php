<?php
class ReplyException extends Exception
{
}
?>


<?php

class Reply
{
    private $db;


    private $id;
    private $postId;
    private $userId;
    private $body;
    private $createdDate;


    public function __construct()
    {
        try {
            $this->db = new Database();
        } catch (PDOException $ex) {
            error_log('fun Post Construct -->: ' . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error !!");
            $response->send();
            exit;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setId($id)
    {
        if (is_null($id))
            throw new ReplyException('Reply ID can\'t be null');
        elseif (empty($id))
            throw new ReplyException('Reply ID can\'t be empty');
        elseif (!is_numeric($id))
            throw new ReplyException('Reply ID must be a number');
        else
            $this->id = $id;
    }

    public function setUserId($userId)
    {
        if (is_null($userId))
            throw new ReplyException('User ID can\'t be null');
        elseif (empty($userId))
            throw new ReplyException('User ID can\'t be empty');
        elseif (!is_numeric($userId))
            throw new ReplyException('User ID must be a number');
        else
            $this->userId = $userId;
    }

    public function setPostId($postId)
    {
        if (is_null($postId))
            throw new ReplyException('Post ID can\'t be null');
        elseif (empty($postId))
            throw new ReplyException('Post ID can\'t be empty');
        elseif (!is_numeric($postId))
            throw new ReplyException('Post ID must be a number');
        else
            $this->postId = $postId;
    }

    public function setBody($replyBody)
    {
        if (is_null($replyBody))
            throw new ReplyException('Reply body can\'t be null');
        elseif (empty($replyBody))
            throw new ReplyException('Reply body can\'t be empty');
        else
            $this->body = $replyBody;
    }


    public function setCreatedDate($createdDate)
    {
        if (is_null($createdDate))
            throw new ReplyException('Creation date can\'t be null');
        else
            $this->createdDate = $createdDate;
    }

    public function setReplyFromRow($row)
    {
        $this->setId($row->id);
        $this->setUserId($row->userId);
        $this->setPostId($row->postId);
        $this->setBody($row->body);
        $this->setCreatedDate($row->createdDate);
    }

    public function setReplyFromArray($data)
    {
        isset($data['id']) ? $this->setId($data['id']) : false;
        isset($data['userId']) ? $this->setUserId($data['userId']) : false;
        isset($data['postId']) ? $this->setPostId($data['postId']) : false;
        isset($data['body']) ? $this->setBody($data['body']) : false;
        isset($data['createdDate']) ? $this->setCreatedDate($data['createdDate']) : false;
    }

    public function returnReplyAsArray()
    {
        $reply = array();

        $reply['id'] = $this->getId();
        $reply['userId'] = $this->getUserId();
        $reply['postId'] = $this->getPostId();
        $reply['body'] = $this->getBody();
        $reply['createdDate'] = $this->getCreatedDate();

        return $reply;
    }




    public function getPostReplies($post)
    {
        $post = intval($post);
        try {

            $this->setPostId($post);

            $this->db->query('SELECT * FROM replies WHERE postId = :post');

            $this->db->bind(':post', $this->postId);

            $rows = $this->db->resultset();

            if ($this->db->rowCount() > 0) {
                $replyArray = array();

                foreach ($rows as $row) {
                    $this->setReplyFromRow($row);


                    $replyArray[] = $this->returnReplyAsArray();
                }
                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['replies'] = $replyArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage('Replies retrievd successfully');
                $response->setData($returnData);
                return $response;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage('Could\'t retrieve replies, please try again');
                $response->send();
                exit;
            }
        } catch (ReplyException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getPostReplies: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function ifReplyExists($id)
    {
        try {
            $this->setId(intval($id));

            $this->db->query('SELECT * FROM replies WHERE id = :reply');
            $this->db->bind(':reply', $this->id);
            $row = $this->db->single();

            if ($this->db->rowCount() > 0)
                return true;

            return false;
        } catch (ReplyException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun replyExist: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function replyExists($uid, $bookId, $replyBody)
    {
        try {

            $this->db->query('SELECT * FROM replies WHERE userId = :user AND postId = :post AND body = :reply');
            $this->db->bind(':user', $uid);
            $this->db->bind(':post', $bookId);
            $this->db->bind(':reply', $replyBody);
            $row = $this->db->single();

            if ($this->db->rowCount() > 0)
                return true;

            return false;
        } catch (ReplyException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun replyExist: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }


    public function getReplyById($id)
    {
        $id = intval($id);
        try {

            $this->setId($id);

            $this->db->query('SELECT * FROM replies WHERE id = :replyId');

            $this->db->bind(':replyId', $this->id);

            $row = $this->db->single();

            if ($this->db->rowCount() > 0)
                return $row;
            else {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Reply not found");
                $response->send();
                exit;
            }
        } catch (ReplyException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun getReply: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function getDetails($rId)
    {
        $rId = intval($rId);

        $this->setId($rId);

        $row = $this->getReplyById($this->id);

        $this->setReplyFromRow($row);

        $replyArray = array();
        $replyArray[] = $this->returnReplyAsArray();

        $returnData = array();

        $returnData['rows_returned'] = $this->db->rowCount();
        $returnData['reply'] = $replyArray;


        $response = new Response();
        $response->setHttpStatusCode(200);
        $response->setSuccess(true);
        $response->toCache(true);
        $response->addMessage("Reply retrived successfully");
        $response->setData($returnData);
        // $response->send();
        return $response;
    }

    public function createReply($data)
    {
        $uId = intval($data['userId']);
        $pId = intval($data['postId']);
        $data['id'] = 999;
        $data['createdDate'] = date("Y-m-d H:i:s");

        try {
            $this->setReplyFromArray($data);

            if ($this->replyExists($this->userId, $this->postId, $this->body)) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("Reply already Posted");
                $response->send();
                exit;
            }

            $this->db->query('INSERT INTO replies (id, userId, postId, body, createdDate) VALUES (null, :userId, :postId, :replyBody, null)');

            $this->db->bind(':userId', $this->userId);
            $this->db->bind(':postId', $this->postId);
            $this->db->bind(':replyBody', $this->body);


            if ($this->db->execute()) {
                $replyId = $this->db->lastInsertId();
                $this->setId($replyId);

                if (is_null($this->id)) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't retrive reply data after posting the comment");
                    $response->send();
                    exit;
                }

                $this->db->query('SELECT * FROM  replies where id = :replyId');
                $this->db->bind(':replyId', $this->id);

                $row = $this->db->single();

                if ($this->db->rowCount() < 1) {
                    $response = new Response();
                    $response->setHttpStatusCode(500);
                    $response->setSuccess(false);
                    $response->addMessage("Couldn't retrive reply data after posting the comment");
                    $response->send();
                    exit;
                }

                $this->setReplyFromRow($row);

                $replyArray = array();

                $replyArray[] = $this->returnReplyAsArray();

                $returnData = array();
                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['replies'] = $replyArray;

                $response = new Response();
                $response->setHttpStatusCode(201);
                $response->setSuccess(true);
                $response->addMessage("Comment posted successfully");
                $response->setData($returnData);
                return $response;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Error posting the comment, please try again");
                $response->send();
                exit;
            }
        } catch (ReplyException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun createReply: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function deleteReply($rId)
    {
        $rId = intval($rId);
        try {
            $this->setId($rId);
            if (!$this->ifReplyExists($this->id)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the reply to delete");
                $response->send();
                exit;
            }

            $this->db->query('DELETE FROM replies WHERE id = :reply');
            $this->db->bind(':reply', $this->id);

            if ($this->db->execute()) {
                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Reply deleted successfully");
                return $response;
            } else {
                $response = new Response();
                $response->setHttpStatusCode(500);
                $response->setSuccess(false);
                $response->addMessage("Couldn't delete the reply");
                $response->send();
                exit;
            }
        } catch (ReplyException $ex) {
            $response = new Response();
            $response->setHttpStatusCode(400);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit;
        } catch (PDOException $ex) {
            error_log("Fun deleteReply: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }

    public function updateReply($id, $data)
    {
        try {
            $this->setId($id);

            if (!$this->ifReplyExists($this->id)) {
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Couldn't find the reply to update");
                $response->send();
                exit;
            }

            $this->setReplyFromRow($this->getReplyById($this->id));

            // Only Data will be updated on use case but I'm implementing logic for other variables too. For future purpose
            $userIdUpdated = false;
            $postIdUpdated = false;
            $bodyUpdated = false;
            $createdDateUpdated = false;

            $queryFields = "";

            if (array_key_exists('userId', $data)) {
                if ((strcmp($data['userId'], $this->userId)) != 0) {
                    $userIdUpdated = true;
                    $this->setUserId($data['userId']);
                    $queryFields .= "userId = :userId, ";
                }
            }

            if (array_key_exists('postId', $data)) {
                if ((strcmp($data['postId'], $this->postId)) != 0) {
                    $postIdUpdated = true;
                    $this->setPostId($data['postId']);
                    $queryFields .= "postId = :postId, ";
                }
            }
            if (array_key_exists('body', $data)) {
                if ((strcmp($data['body'], $this->body)) != 0) {
                    $bodyUpdated = true;
                    $this->setBody($data['body']);
                    $queryFields .= "body = :body, ";
                }
            }
            if (array_key_exists('createdDate', $data)) {
                if ((strcmp($data['createdDate'], $this->createdDate)) != 0) {
                    $createdDateUpdated = true;
                    $this->setUserId($data['createdDate']);
                    $queryFields .= "createdDate = :createdDate, ";
                }
            }

            $queryFields = rtrim($queryFields, ", ");

            if (!$userIdUpdated && !$postIdUpdated && !$bodyUpdated && !$createdDateUpdated) {
                $response = new Response();
                $response->setHttpStatusCode(400);
                $response->setSuccess(false);
                $response->addMessage("No new information to update");
                $response->send();
                exit;
            }

            $this->db->query("UPDATE replies SET " . $queryFields . " WHERE id = :replyId");
            $this->db->bind(':replyId', $this->id);

            if ($userIdUpdated)
                $this->db->bind(':userId', $this->userId);

            if ($postIdUpdated)
                $this->db->bind(':postId', $this->postId);

            if ($bodyUpdated)
                $this->db->bind(':body', $this->body);

            if ($createdDateUpdated)
                $this->db->bind(':createdDate', $this->createdDate);

            $this->db->execute();

            if ($this->db->rowCount() > 0) {

                $row = $this->getReplyById($this->id);

                $this->setReplyFromRow($row);

                $replyArray = array();
                $replyArray[] = $this->returnReplyAsArray();

                $returnData = array();

                $returnData['rows_returned'] = $this->db->rowCount();
                $returnData['replies'] = $replyArray;

                $response = new Response();
                $response->setHttpStatusCode(200);
                $response->setSuccess(true);
                $response->addMessage("Reply updated successfully");
                $response->setData($returnData);
                return $response;
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
            error_log("Fun updateReply: " . $ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Database Error");
            $response->send();
            exit;
        }
    }




}


?>
