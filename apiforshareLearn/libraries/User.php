<?php

use function PHPSTORM_META\type;

class User
{
    private $db;


    public function __construct()
    {

        $this->db = new Database;
    }



    public function login($userEmail, $password)
    {
        $this->db->query("SELECT * From user
        WHERE email = :email AND password = :password
        ");
        $this->db->bind(":email", $userEmail);
        $this->db->bind(":password", $password);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            $this->setUserData($row);
            return true;
        } else
            return false;
    }


    private function setUserData($row)
    {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id'] = $row->id;
        $_SESSION['username'] = $row->userName;
        $_SESSION['name'] = $row->firstName;
    }


    public function logout()
    {
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['name']);
        return true;
    }


    public function getUserInfo($uid)
    {
        $this->db->query("SELECT * FROM user WHERE id = :userId");

        $this->db->bind(':userId', $uid);

        $row = $this->db->single();

        return $row;
    }


    public function userOverallRating($uid)
    {
        $totalRating = 0;
        $this->db->query("SELECT postRating FROM post WHERE userId = :userId");

        $this->db->bind(':userId', $uid);

        $ratings = $this->db->resultset();

        foreach ($ratings as $rating) {
            $totalRating += $rating->postRating;
        }

        return $totalRating;
    }

    public function addFollower($uid, $followerId)
    {
        $this->db->query("SELECT * FROM user WHERE id = :userId");
        $this->db->bind(':userId', $uid);
        $userInfo = $this->db->single();

        $followers = $userInfo->followers;

        $followers = explode(',', $followers);
        $followers = array_values(array_filter($followers));

        if (in_array($followerId, $followers)) {
            return false;
        } else {

            $followers = implode(',', $followers);

            $follower = $followerId . ',';

            $followers .= $follower;

            $this->db->query("UPDATE user SET followers = :followers WHERE id = :userId");

            $this->db->bind(':userId', $uid);
            $this->db->bind(':followers', $followers);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function removeFollower($uid, $unfollowerId)
    {
        $this->db->query("SELECT * FROM user WHERE id = :userId");
        $this->db->bind(':userId', $uid);
        $userInfo = $this->db->single();

        $followers = $userInfo->followers;

        $followers = explode(',', $followers);

        foreach ($followers as $key => $follower) {
            if ($follower == $unfollowerId) {
                unset($followers[$key]);
            }
        }

        $followers = array_values(array_filter($followers));

        $followers = implode(',', $followers);

        $followers = $followers . ',';

        $this->db->query("UPDATE user SET followers = :followers WHERE id = :userId");

        $this->db->bind(':userId', $uid);
        $this->db->bind(':followers', $followers);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function userFollowersCount($uid)
    {
        $this->db->query("SELECT followers FROM user WHERE id = :userId");

        $this->db->bind(':userId', $uid);

        $row = $this->db->single();

        $followers = $row->followers;

        $followers = explode(',', $followers);

        $followers = array_values(array_filter($followers));

        $followersCount = count($followers);

        return $followersCount;
    }


    public function addToWishlist($user, $post)
    {
        // $this->db->query("SELECT wishlisted FROM user WHERE id = :userId");

        // $this->db->bind(':userId', $user);

        // $wishlist = $this->db->single();

        // $wishlistList = $wishlist->wishlisted;

        // $addingString = $post . ',';

        // $wishlistList .= $addingString;

        // $this->db->query("UPDATE user SET wishlisted = :wishlistedPosts WHERE id = :userId");

        // $this->db->bind(':userId', $user);
        // $this->db->bind(':wishlistedPosts', $wishlistList);

        // if ($this->db->execute()) {
        //     return true;
        // } else {
        //     return false;
        // }



        $this->db->query("SELECT * FROM user WHERE id = :userId");
        $this->db->bind(':userId', $user);
        $userInfo = $this->db->single();

        $wishlistList = $userInfo->wishlisted;

        $wishlistList = explode(',', $wishlistList);
        $wishlistList = array_values(array_filter($wishlistList));

        if (in_array($post, $wishlistList)) {
            return false;
        } else {

            $wishlistList = implode(',', $wishlistList);

            $wishlistingPost = ',' . $post . ',';

            $wishlistList .= $wishlistingPost;

            $this->db->query("UPDATE user SET wishlisted = :wishlist WHERE id = :userId");

            $this->db->bind(':userId', $user);
            $this->db->bind(':wishlist', $wishlistList);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function removeFromWishlist($user, $post)
    {

        $this->db->query("SELECT * FROM user WHERE id = :userId");
        $this->db->bind(':userId', $user);
        $userInfo = $this->db->single();

        $wishlistList = $userInfo->wishlisted;

        $wishlistList = explode(',', $wishlistList);

        foreach ($wishlistList as $key => $wishlistItem) {
            if ($wishlistItem == $post) {
                unset($wishlistList[$key]);
            }
        }

        $wishlistList = array_values(array_filter($wishlistList));

        $wishlistList = implode(',', $wishlistList);

        $wishlistList = $wishlistList . ',';

        $this->db->query("UPDATE user SET wishlisted = :wishlist WHERE id = :userId");

        $this->db->bind(':userId', $user);
        $this->db->bind(':wishlist', $wishlistList);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getWishlistedBooksIds()
    {
        $uid = $_SESSION['user_id'];

        $this->db->query("SELECT wishlisted FROM user WHERE id = :userId");

        $this->db->bind(':userId', $uid);

        $wishlist = $this->db->single();

        $wishlistList = $wishlist->wishlisted;

        $wishlistList = explode(',', $wishlistList);

        $wishlistList = array_values(array_filter($wishlistList));

        return $wishlistList;
    }


    public function userWishlistCount($uid)
    {
        // $uid = $_SESSION['user_id'];

        $this->db->query("SELECT wishlisted FROM user WHERE id = :userId");

        $this->db->bind(':userId', $uid);

        $wishlist = $this->db->single();

        $wishlistList = $wishlist->wishlisted;

        $wishlistList = explode(',', $wishlistList);

        $wishlistList = array_values(array_filter($wishlistList));


        return count($wishlistList);
    }
}
