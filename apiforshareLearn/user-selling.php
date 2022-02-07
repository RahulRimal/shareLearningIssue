
<?php
require('core/init.php');
?>

<?php

$template = new Template('templates/user-posts.php');

$book = new Post();
$user = new User();


if (isset($_GET['nU'])) {
    $nextUser = $_GET['nU'];

    // $userAllPosts = $book->getUserAllPosts($nextUser);

    $template->userInfo = $user->getUserInfo($nextUser);

    // $template->userAllPosts = $userAllPosts;
    $template->userAllPosts = $book->getUserAllPosts($nextUser);

} else {

    if (isLoggedIn()) {
        $userId = $_SESSION['user_id'];

        $userAllPosts = $book->getUserAllPosts($userId);

        $template->userAllPosts = $userAllPosts;
    } else {
        redirect('index.php', 'Please log in to see your posts !!', 'error');
    }
}

echo $template;

?>