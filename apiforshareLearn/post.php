<?php require('core/init.php'); ?>


<?php

$template = new Template('templates/post-page.php');

$post = new Post();
$user = new User();

$postId = isset($_GET['post']) ? $_GET['post'] : null;


if ($postId != null) {
    $uid = $post->userIdFromPost($postId);

    $_SESSION['nextPerson'] = $uid;

    $template->postId = $postId;
    $template->nextUserInfo = $user->getUserInfo($uid);

    $template->followers = $user->userFollowersCount($uid);
    $template->userRating = $user->userOverallRating($uid);

    $template->post = $post->getPost($postId);

    $template->postComments = $post->getReplies($postId);

    $template->userWishlistCount = $user->userWishlistCount($uid);

} else {
    redirect('index.php');
}



// if(isset($_POST['doReply']))
// {

//     $data = array();
//     $data['postId'] = $_GET['post'];

//     $data['body'] = $_POST['comment-body'];
//     // $data['userId'] = $post->userIdFromPost($postId);
//     $data['userId'] = $_SESSION['user_id'];

//     $validate = new Validator();

//     // Required Fields

//     $field_array = array('body');

//     if($validate->isRequired($field_array))
//     {
//         // die($post->reply($data));
//         if($post->reply($data))
//         {
//             redirect('post.php?post='.$postId, 'Your reply has been posted.', 'success');
//             // redirect('index.php', 'Your reply has been posted.', 'success');
//         }
//         else
//         {
//             redirect('post.php?post='.$postId, 'Something went wrong, Please try again.', 'error');
//             // redirect('index.php', 'Something went wrong, Please try again.', 'error');
//         }
//     }
//     else
//         redirect('post.php?post='.$postId, 'Cannot reply a blank comment', 'error');
//         // redirect('index.php', 'Cannot reply a blank comment', 'error');

// }


if (isset($_POST['commentPostId']) && isset($_POST['commentBody'])) {
    echo ('hereeee');
    die();
    $data = array();
    $data['postId'] = $_POST['commentPostId'];
    $data['body'] = $_POST['commentBody'];
    $data['userId'] = $_SESSION['user_id'];

    // echo $post->reply($data);
    // die();

    $validate = new Validator();

    // Required Fields

    $field_array = array('body');

    if ($validate->isRequired($field_array)) {
        // die($post->reply($data));
        if ($post->reply($data)) {
            echo '<div class="custom-alert alert-success temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Your comment has been posted</div>';

            // $replies = $post->getReplies($data['postId']);

            // echo $replies;
            die();
        } else {
            echo '<div class="custom-alert alert-danger temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Could not post your comment</div>';
            die();
        }
    } else {
        echo '<div class="custom-alert alert-danger temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Empty Comment</div>';
        die();
    }

    die();
}

// if (isset($_POST['followerId']) && isset($_POST['followedId'])) {
//     $followerId = $_POST['followerId'];
//     $followedId = $_POST['followedId'];

//     if ($user->addFollower($followedId, $followerId)) {
//         $newCount = $user->userFollowersCount($followedId);
//     } else {
//         $newCount = $user->userFollowersCount($followedId);
//     }

//     echo $newCount;
//     die();
// }

// if (isset($_POST['unfollowerId']) && isset($_POST['unfollowedId'])) {
//     $unfollowerId = $_POST['unfollowerId'];
//     $unfollowedId = $_POST['unfollowedId'];

//     if ($user->removeFollower($unfollowedId, $unfollowerId)) {
//         $newCount = $user->userFollowersCount($unfollowedId);
//     }

//     echo $newCount;
//     die();
// }

echo $template;

?>