<?php require('core/init.php');?>


<?php

$template = new Template('templates/user-posts.php');

$post = new Post();
$user = new User();

if(isset($_GET['user']))
{
    $userId = $_GET['user'];

    $template->userInfo = $user->getUserInfo($userId);

    $template->userAllPosts = $post->getUserAllPosts($userId);

    $template->userRating = $user->userOverallRating($userId);

    $template->followers = $user->userFollowersCount($userId);
}
else
{
    $template->userAllPosts = $post->getAllPosts();
}



echo $template;
?>