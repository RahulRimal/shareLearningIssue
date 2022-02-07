
<?php
    require('core/init.php');
?>

<?php

$user = new User();

if (isset($_POST['followerId']) && isset($_POST['followedId'])) {
    $followerId = $_POST['followerId'];
    $followedId = $_POST['followedId'];

    if ($user->addFollower($followedId, $followerId)) {
        $newCount = $user->userFollowersCount($followedId);
    } else {
        $newCount = $user->userFollowersCount($followedId);
    }

    echo $newCount;
    die();
}

if (isset($_POST['unfollowerId']) && isset($_POST['unfollowedId'])) {
    $unfollowerId = $_POST['unfollowerId'];
    $unfollowedId = $_POST['unfollowedId'];

    if ($user->removeFollower($unfollowedId, $unfollowerId)) {
        $newCount = $user->userFollowersCount($unfollowedId);
    }
    else
    {
        $newCount = $user->userFollowersCount($unfollowedId);
    }

    echo $newCount;
    die();
}

echo 'Nope';

?>