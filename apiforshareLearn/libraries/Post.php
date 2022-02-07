<?php

class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getSellingPostsCount($uid)
    {

        $this->db->query("SELECT * FROM post WHERE userId = :userId");
        $this->db->bind(':userId', $uid);

        $rows = $this->db->resultset();
        
        return $this->db->rowCount();

    }

    public function getBuyingPostsCount($uid)
    {

        $this->db->query("SELECT wishlisted FROM user WHERE id = :userId");

        $this->db->bind(':userId', $uid);

        $wishlist = $this->db->single();

        $wishlistList = $wishlist->wishlisted;

        $wishlistList = explode(',', $wishlistList);

        return count($wishlistList);
    }


    public function getUserAllPosts($uid)
    {
        $this->db->query("SELECT * FROM post WHERE userId = :userId ");
        $this->db->bind(':userId', $uid);

        $rows = $this->db->resultset();

        return $rows;
    }

    public function getAllPosts()
    {
        $this->db->query("SELECT * FROM post");

        $rows = $this->db->resultset();

        return $rows;
    }


    public function getFilteredPosts()
    {
        $this->db->query("SELECT * FROM post");

        $rows = $this->db->resultset();

        return $rows;
    }

    public function getPost($pid)
    {
        $this->db->query("SELECT * FROM post WHERE id = :postId ");
        $this->db->bind(':postId', $pid);

        $row = $this->db->single();

        return $row;
    }

    public function userIdFromPost($pid)
    {
        $this->db->query("SELECT userId FROM post WHERE id = :postId");

        $this->db->bind(':postId', $pid);

        $row = $this->db->single();

        return $row->userId;
    }



    public function reply($data)
    {
        $this->db->query("INSERT INTO replies(postId, userId, body)
                         VALUES(:postId, :userId, :body)
                        ");
            
        $this->db->bind(':postId', $data['postId']);
        $this->db->bind(':userId', $data['userId']);
        $this->db->bind(':body', $data['body']);

        if($this->db->execute())
            return true;
        else
            return false;

        // if($this->db->execute())
        //     {
        //         echo '<script>alert("Your reply has been posted.");</script>';
        //         die();
        //     }
        // else
        //     {
        //         echo '<script>alert("Something went wrong, Please try again.");</script>';
        //         die();
        //     }

    }


    public function getReplies($postId)
    {
        $this->db->query('SELECT * FROM replies WHERE postId = :postId');
        $this->db->bind(':postId', $postId);

        $rows = $this->db->resultset();

        return $rows;

    }



}
