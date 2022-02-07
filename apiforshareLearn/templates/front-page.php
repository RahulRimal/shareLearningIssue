    <?php include('includes/header.php'); ?>
    <main class="my-2">

        <!-- main wide content starts here  -->

        <div class="main-wide-content container-fluid">

        </div>

        <!-- main wide content ends here  -->

        <!-- main narrow content starts here  -->

        <div class="main-content container mt-5">
            <div class="row">
                <!-- Left sidebar starts here  -->
                <?php if (isLoggedIn()) : ?>
                    <?php include('includes/left-sidebar.php'); ?>
                <?php endif; ?>
                <!-- Left sidebar ends here  -->

                <!-- main center content starts here  -->

                <div class="main-center-content <?php if (isLoggedIn()) echo ('col-lg-6');
                                                else echo ('col-lg-9'); ?>">
                    <div class="user-preferred-posts">
                        <?php foreach ($allPosts as $post) : ?>
                            <?php if ($post->postType == 0) : ?>
                                <!-- User post starts here  -->
                                <!-- <div class="user-post bg-white position-relative p-3 mb-4 rounded" onclick="location.href = 'post.php?post=<? //php echo $post->id; 
                                                                                                                                                ?>';" style="cursor: pointer;"> -->
                                <div class="user-post bg-white position-relative p-3 mb-4 rounded" style="cursor: pointer;">
                                    <div class="post-selling-tag p-1">
                                        <div class="selling">
                                            <h6 class="m-0">Selling</h6>
                                        </div>
                                    </div>
                                    <div class="post-title-status d-flex justify-content-between">
                                        <div class="post-title">
                                            <a href="post.php?post=<?php echo $post->id; ?>">
                                                <h5><?php echo $post->bookName; ?></h5>
                                            </a>
                                        </div>

                                        <div class="post-status">
                                            <a href="#">
                                                <h5 class="text-success">Available</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="post-info-action d-flex justify-content-between align-items-center">
                                        <div class="post-info d-flex">
                                            <div class="book-author me-5 text-center">
                                                <p class="m-0"><i class="fa fa-user text-muted" aria-hidden="true"></i> Author
                                                </p>
                                                <h6 class="font-italic"><?php echo $post->author; ?></h6>
                                            </div>
                                            <div class="bought-time me-5 text-center">
                                                <p class="m-0"><i class="fa fa-history text-muted" aria-hidden="true"></i>
                                                    Bought
                                                    Time
                                                </p>
                                                <h6 class="font-italic text-warning">1 Year ago</h6>
                                            </div>
                                            <div class="book-price me-5 text-center">
                                                <p class="m-0"><i class="fas fa-coins text-muted" aria-hidden="true"></i> Price
                                                </p>
                                                <h6" class="font-italic text-success">Rs. <?php echo $post->price; ?></h6>
                                            </div>
                                        </div>
                                        <?php if (isLoggedIn()) : ?>
                                            <?php if ($post->userId == $_SESSION['user_id']) : ?>
                                                <div class="post-action me-5">
                                                    <div class="delete-post-action d-flex flex-column align-items-center">
                                                        <a href="#">
                                                            <i class="fa fa-trash" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="#">
                                                            <p class="delete-post text-center" style="color: var(--primary-color);">Delete Post</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <?php if (hasWishlisted($_SESSION['user_id'], $post->id)) : ?>
                                                    <div class="post-action me-5">
                                                        <div class="wishlist-remove d-flex flex-column align-items-center">
                                                            <a href="#">
                                                                <i class="fa fa-close" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="#">
                                                                <p class="remove-from-wishist text-center" style="color: var(--primary-color);" onclick="removeFromWishlist(<?php echo $_SESSION['user_id']; ?>, <?php echo $post->id; ?>, this)">Remove from Wishlist</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="post-action me-5">
                                                        <div class="wishlist d-flex flex-column align-items-center">
                                                            <a href="#">
                                                                <i class="fa fa-shopping-basket" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="#">
                                                                <p class="user-add-wishlist text-center" style="color: var(--primary-color);" onclick="addToWishlist(<?php echo $_SESSION['user_id']; ?>, <?php echo $post->id; ?>, this)">Add to Wishlist</p>
                                                            </a>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endif; ?>
                                        <?php else : ?>
                                            <div class="post-action me-5">
                                                <div class="wishlist d-flex flex-column align-items-center">
                                                    <a href="#">
                                                        <i class="fa fa-shopping-basket" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                    </a>
                                                    <!-- <a href="#">
                                        <p style="color: var(--primary-color);">Add to Wishlist</p>
                                    </a> -->
                                                    <p class="login-to-wishlist text-center" style="color: var(--primary-color);">Add to Wishlist</p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="post-desc mt-4">
                                        <p class="text-truncate"><?php echo $post->description; ?></p>
                                    </div>
                                    <div class="post-alert-area">

                                    </div>
                                </div>

                                <!-- User post ends here  -->

                            <?php else : ?>

                                <!-- User post starts here  -->
                                <!-- <div class="user-post bg-white position-relative p-2 mb-4 rounded" onclick="location.href = 'post.php?post=<? //php echo $post->id; 
                                                                                                                                                ?>';" style="cursor: pointer;"> -->
                                <div class="user-post bg-white position-relative p-2 mb-4 rounded" style="cursor: pointer;">
                                    <div class="post-buying-tag p-1">
                                        <div class="buying">
                                            <h6 class="m-0">Buying</h6>
                                        </div>
                                    </div>
                                    <div class="post-title-status d-flex justify-content-between">
                                        <div class="post-title">
                                            <a href="post.php?post=<?php echo $post->id; ?>">
                                                <h5><?php echo $post->bookName; ?></h5>
                                            </a>
                                        </div>

                                        <!-- <div class="post-status">
                                <a href="#">
                                    <h5 class="text-success">Available</h5>
                                </a>
                            </div> -->
                                    </div>
                                    <div class="post-info-action d-flex justify-content-between align-items-center">
                                        <div class="post-info d-flex">
                                            <div class="book-author me-5 text-center">
                                                <p class="m-0"><i class="fa fa-user text-muted" aria-hidden="true"></i> Author
                                                </p>
                                                <h6 class="font-italic"><?php echo $post->author; ?></h6>
                                            </div>
                                            <div class="bought-time me-5 text-center">
                                                <p class="m-0"><i class="fa fa-history text-muted" aria-hidden="true"></i>
                                                    Bought
                                                    Time
                                                </p>
                                                <h6 class="font-italic text-warning">1 Year ago</h6>
                                            </div>
                                            <div class="book-price me-5 text-center">
                                                <p class="m-0"><i class="fas fa-coins text-muted" aria-hidden="true"></i> Price
                                                </p>
                                                <h6" class="font-italic text-success">Rs. <?php echo $post->price; ?></h6>
                                            </div>
                                        </div>

                                        <?php if (isLoggedIn()) : ?>
                                            <?php if ($post->userId == $_SESSION['user_id']) : ?>
                                                <div class="post-action me-5">
                                                    <div class="delete-post-action d-flex flex-column align-items-center">
                                                        <a href="#">
                                                            <i class="fa fa-trash" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="#">
                                                            <p class="delete-post text-center" style="color: var(--primary-color);">Delete Post</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <?php if (hasWishlisted($_SESSION['user_id'], $post->id)) : ?>
                                                    <div class="post-action me-5">
                                                        <div class="wishlist-remove d-flex flex-column align-items-center">
                                                            <a href="#">
                                                                <i class="fa fa-close" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="#">
                                                                <p class="remove-from-wishist text-center" style="color: var(--primary-color);" onclick="removeFromWishlist(<?php echo $_SESSION['user_id']; ?>, <?php echo $post->id; ?>, this)">Remove from Wishlist</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="post-action me-5">
                                                        <div class="wishlist d-flex flex-column align-items-center">
                                                            <a href="#">
                                                                <i class="fa fa-shopping-basket" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="#">
                                                                <p class="user-add-wishlist text-center" style="color: var(--primary-color);" onclick="addToWishlist(<?php echo $_SESSION['user_id']; ?>, <?php echo $post->id; ?>, this)">Add to Wishlist</p>
                                                            </a>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endif; ?>
                                        <?php else : ?>
                                            <div class="post-action me-5">
                                                <div class="wishlist d-flex flex-column align-items-center">
                                                    <a href="#">
                                                        <i class="fa fa-shopping-basket" style="color: var(--primary-color);" aria-hidden="true"></i>
                                                    </a>
                                                    <!-- <a href="#">
                                        <p style="color: var(--primary-color);">Add to Wishlist</p>
                                    </a> -->
                                                    <p class="login-to-wishlist text-center" style="color: var(--primary-color);">Add to Wishlist</p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="post-desc mt-4">
                                        <p class="text-truncate"><?php echo $post->description; ?></p>
                                    </div>
                                    <div class="post-alert-area">

                                    </div>
                                </div>
                                <!-- User post ends here  -->
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- main center content ends here  -->


                <!-- Right sidebar starts here  -->
                <?php include('includes/right-sidebar.php'); ?>

                <!-- Right sidebar ends here  -->
            </div>

        </div>

        <!-- main narrow content ends here  -->


        <!-- Chat system Strats Here -->
        <?php include('includes/chat-system.php'); ?>
        <!-- Chat system Ends Here -->

    </main>



    <?php include('includes/footer.php'); ?>