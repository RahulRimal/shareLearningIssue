<?php



function isFollowing($follower, $followed)
{
    $db = new Database();

    $db->query("SELECT * FROM user WHERE id = :userId");
    $db->bind(':userId', $followed);
    $followedUser = $db->single();

    $followers = $followedUser->followers;

    $followers = explode(',', $followers);

    $followers = array_values(array_filter($followers));

    if (in_array($follower, $followers)) {
        return true;
    } else {
        return false;
    }
}

function isSameUser($user1, $user2)
{
    if ($user1 == $user2) {
        return true;
    } else {
        return false;
    }
}


function currentUserInfo($uId)
{
    $db = new Database();

    $db->query("SELECT * FROM user WHERE id = :userId");
    $db->bind(':userId', $uId);
    $user = $db->single();
    return $user;
}

// function userWishlistCount()
// {
//     $db = new Database();
//     $uid = $_SESSION['user_id'];

//     $db->query("SELECT wishlisted FROM user WHERE id = :userId");

//     $db->bind(':userId', $uid);

//     $wishlist = $db->single();

//     $wishlistList = $wishlist->wishlisted;

//     $wishlistList = explode(',', $wishlistList);

//     $wishlistList = array_values(array_filter($wishlistList));


//     return count($wishlistList);
// }
