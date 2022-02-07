
<?php
    require('core/init.php');
?>

<?php

$template = new Template('templates/wishlisted-books.php');

$user = new User();
$book = new Post();

$wishlistedBooksIds = $user->getWishlistedBooksIds();

$wishlistedBooks = array();

foreach($wishlistedBooksIds as $bookId)
{
    $wishlistedBooks[] = $book->getPost($bookId);
}

$template->wishlistedBooks = array_values(array_filter($wishlistedBooks));

if(isset($_POST['wishlistingUser']) && isset($_POST['wishlistingPost']))
{
    $wishlister = $_POST['wishlistingUser'];
    $wishlistingPost = $_POST['wishlistingPost'];

    if($user->addToWishlist($wishlister, $wishlistingPost))
    {
        $newWishlistedCount = $user->userWishlistCount($wishlister);
    }
    else
    {
        $newWishlistedCount = $user->userWishlistCount($wishlister);
    }

    echo $newWishlistedCount;
    
    die();

}

// if(isset($_POST['wishlistRemovingUser']))
if(isset($_POST['wishlistRemovingUser']) && isset($_POST['wishlistRemovingPost']))
{

    // console.log($_POST['wishlistRemovingUser']);


    $wishlistRemover = $_POST['wishlistRemovingUser'];
    $beingDeletedFromWishlist = $_POST['wishlistRemovingPost'];

    if($user->removeFromWishlist($wishlistRemover, $beingDeletedFromWishlist))
    {
        $newWishlistedCount = $user->userWishlistCount($wishlistRemover);
    }
    else
    {
        $newWishlistedCount = $user->userWishlistCount($wishlistRemover);
    }

    echo $newWishlistedCount;
    
    die();

}



echo $template;

?>