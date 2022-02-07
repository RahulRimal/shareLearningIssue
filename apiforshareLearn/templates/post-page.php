<?php include('includes/header.php');?>

<main class="my-2">

    <!-- main wide content starts here  -->

    <div class="main-wide-content container-fluid">

    </div>

    <!-- main wide content ends here  -->

    <!-- main narrow content starts here  -->

    <div class="main-content container mt-5">
        <div class="row">
            <!-- Left sidebar starts here  -->

            <!-- Left sidebar ends here  -->

            <!-- main center content starts here  -->

            <div class="main-center-content col-lg-9">

                <div class="single-post">
                    <div class="user-post bg-white position-relative p-2 mb-4 rounded">
                        <div class="post-title mb-5">
                            <h5 class="text-center h4"><?php echo $post->bookName;?></h5>
                        </div>
                        <div class="post-info-desc d-flex align-items-center">
                            <div class="post-info d-flex">
                                <div class="book-author mx-4 text-center">
                                    <p class="m-0"><i class="fa fa-user text-muted" aria-hidden="true"></i> Author
                                    </p>
                                    <h6 class="font-italic" style="color: var(--primary-color);">
                                        <?php echo $post->author;?></h6>
                                </div>
                            </div>
                            <div class="post-time-desc">
                                <div class="bought-time text-center bg-warning text-white">
                                    <p class="m-0 h6" style="height: 25px; line-height: 25px;">
                                        Bought <span class="font-italic">1 Year ago</span>
                                    </p>
                                </div>

                                <div class="post-desc">
                                    <p><?php echo $post->description;?></p>
                                </div>
                                <div class="book-price bg-success text-center">
                                    <h6" class="font-italic text-white">Total Price: <strong>Rs.
                                            <?php echo $post->price;?></strong></h6>
                                </div>
                            </div>
                        </div>

                        <div class="sell-book-post-pics py-3" style="text-align: -webkit-center;">
                            <ul style="margin:0;padding:0;list-style:none;" id="sellBookPostPics" class="cs-hidden">
                                <li class="item-a" style="margin:0;padding:0;list-style:none;"><img
                                        src="<?php echo BASE_URI;?>images/Share Your Learning.png" alt=""></li>
                                <li class="item-b" style="margin:0;padding:0;list-style:none;"><img
                                        src="https://cdn.pixabay.com/photo/2021/07/02/03/19/panpipe-6380762__340.jpg"
                                        alt=""></li>
                                <li class="item-c" style="margin:0;padding:0;list-style:none;"><img
                                        src="<?php echo BASE_URI;?>images/Share Your Learning.png" alt=""></li>
                                <li class="item-b" style="margin:0;padding:0;list-style:none;"><img
                                        src="https://cdn.pixabay.com/photo/2021/07/02/03/19/panpipe-6380762__340.jpg"
                                        alt=""></li>
                                <li class="item-d" style="margin:0;padding:0;list-style:none;"><img
                                        src="<?php echo BASE_URI;?>images/Share Your Learning.png" alt=""></li>
                            </ul>
                        </div>


                        <div class="post-comments">
                            <div class="comments-header d-flex justify-content-around align-items-center">
                                <p class="h6">Comments</p>
                                <hr class="w-75" style="color: var(--primary-color);">
                            </div>
                            <div class="comments-body rounded p-3" style="background-color: var(--primary-bg-color);">

                                <?php foreach($postComments as $postComment):?>
                                <!-- Comment Starts here  -->
                                <!-- <div class="post-comment d-flex justify-content-between bg-white p-3 mb-3"
                                    style="border-radius: 25px;">
                                    <div class="comment-profile mx-4">
                                        <a href="#">
                                            <img src="<?php echo BASE_URI;?>/images/<?php echo $nextUserInfo->picture;?>"
                                                class="circle-avatar" style="height: 50px; width: 50px;">
                                        </a>
                                        <a href="#" class="user-name font-italic h6"
                                            style="color: var(--primary-color);">
                                            <?php echo ("{$nextUserInfo->firstName} "); echo $nextUserInfo->lastName;?></a>
                                    </div>
                                    <div class="comment-text">
                                        <p><?php echo $postComment->body;?></p>
                                    </div>
                                </div> -->
                                <!-- Comment Ends here  -->

                                <!-- Comment Starts here  -->
                                <div class="post-comment bg-white p-3 mb-3" style="border-radius: 25px;">
                                    <div class="row">
                                        <div class="comment-profile col-3 mx-4">
                                            <a href="#">
                                                <img src="<?php echo BASE_URI;?>/images/<?php echo $nextUserInfo->picture;?>"
                                                    class="circle-avatar" style="height: 50px; width: 50px;">
                                            </a>
                                            <a href="#" class="user-name font-italic h6"
                                                style="color: var(--primary-color);">
                                                <?php echo ("{$nextUserInfo->firstName} "); echo $nextUserInfo->lastName;?></a>
                                        </div>
                                        <div class="comment-text col-8">
                                            <p><?php echo $postComment->body;?></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Ends here  -->

                                <?php endforeach;?>

                                <div class="comment-footer">
                                    <div class="comment-reply">
                                        <?php if(isLoggedIn()):?>
                                            <p class="h5">Add your comment</p>
                                            <div id="comment-alert-area">

                                            </div>
                                        <!-- <form id="post-comment-form" role="form" method="post" action="post.php?id=<?//php echo $post->id; ?>"> -->
                                        <form id="post-comment-form">
                                            <div class="form-group">
                                                <input id="commentPostId" type="text" value="<?php echo $post->id;?>" hidden>
                                                <textarea id="replyBody" rows="10" cols="80" class="form-control"
                                                    name="comment-body"></textarea>
                                                <script>
                                                CKEDITOR.replace('replyBody');
                                                </script>
                                            </div>
                                            <div class="reply-button text-end">
                                                <button id="comment-reply-button" name="doReply" type="submit" class="btn w-25"
                                                    style="background-color: var(--primary-color);">Submit</button>
                                            </div>
                                        </form>
                                        <?php else:?>
                                        <p style="color: var(--primary-color);" class="h4 text-center">Please <a
                                                class="text-primary" href="#">Log In</a> to Reply to this post</p>
                                        <?php endif;?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- main center content ends here  -->


            <!-- Right sidebar starts here  -->
            <?php include('includes/right-sidebar.php');?>

            <!-- Right sidebar ends here  -->
        </div>

    </div>

    <!-- main narrow content ends here  -->


    <!-- Chat system Strats Here -->
    <?//php include('includes/chat-system.php');?>
    <!-- Chat system Ends Here -->

</main>


<?php include('includes/footer.php');?>