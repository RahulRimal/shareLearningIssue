
<?php
    require('core/init.php');
?>

<?php

$template = new Template('templates/front-page.php');


$post = new Post();

if(isLoggedIn())
{
    $user = new User();
    
    $uid = $_SESSION['user_id'];

    $template->userInfo = $user->getUserInfo($uid);

    $template->allPosts = $post->getFilteredPosts();

    $template->sellingPostsCount = $post->getSellingPostsCount($uid);
    $template->buyingPostsCount = $post->getBuyingPostsCount($uid);

    $template->userWishlistCount = $user->userWishlistCount($uid);

    isset($_SESSION['nextPerson']) ? $template->nextUserInfo = $user->getUserInfo($_SESSION['nextPerson']) : null;

}

else
{
    $template->allPosts = $post->getAllPosts();
}

echo $template;

?>