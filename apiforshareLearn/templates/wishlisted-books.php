<?php include('includes/header.php') ?>

<main class="my-2">

    <!-- main wide content starts here  -->

    <div class="main-wide-content container-fluid">

    </div>

    <!-- main wide content ends here  -->

    <!-- main narrow content starts here  -->

    <div class="main-content container mt-5">
        <div class="user-all-posts">

            <?php foreach ($wishlistedBooks as $post) : ?>
                <!-- User post starts here  -->
                <div class="user-post bg-white position-relative p-3 mb-4 rounded"
                        onclick="location.href = 'post.php?post=<?php echo $post->id;?>';"
                        style="cursor: pointer;">
                        <div class="post-selling-tag p-1">
                            <div class="selling">
                                <h6 class="m-0">Selling</h6>
                            </div>
                        </div>
                        <div class="post-title-status d-flex justify-content-between">
                            <div class="post-title">
                                <a href="post.php?post=<?php echo $post->id;?>">
                                    <h5><?php echo $post->bookName;?></h5>
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
                                    <h6 class="font-italic"><?php echo $post->author;?></h6>
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
                                    <h6" class="font-italic text-success">Rs. <?php echo $post->price;?></h6>
                                </div>
                            </div>

                            <div class="post-action me-5">
                                <div class="wishlist d-flex flex-column align-items-center">
                                    <a href="#">
                                        <i class="fa fa-shopping-basket" style="color: var(--primary-color);"
                                            aria-hidden="true"></i>
                                    </a>
                                    <a href="#">
                                        <p style="color: var(--primary-color);">Add to Wishlist</p>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="post-desc mt-4">
                            <p class="text-truncate"><?php echo $post->description;?></p>
                        </div>
                    </div>
                    <!-- User post ends here  -->

            <?php endforeach; ?>

        </div>
    </div>

    <!-- main narrow content ends here  -->

</main>



<!-- Footer starts here -->

<?php include('includes/footer.php') ?>