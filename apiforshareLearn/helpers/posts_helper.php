<?php

function userPostsCount()
{
    $db = new Database();
    $userId = $_SESSION['user_id'];

    $db->query("SELECT * FROM post WHERE userId = :userId");
    $db->bind(':userId', $userId);

    $rows = $db->resultset();
    
    return $db->rowCount();
}

function hasWishlisted($user, $post)
{
    $db = new Database();
    
    $db->query('SELECT wishlisted FROM user WHERE id = :userId');
    $db->bind(':userId', $user);

    $wishlistedPosts = $db->single();

    $wishlistedPosts = explode(',', $wishlistedPosts->wishlisted);

    if(in_array($post, $wishlistedPosts))
        return true;

    return false;


}
















?>