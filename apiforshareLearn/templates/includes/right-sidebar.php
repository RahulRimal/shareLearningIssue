<!-- Right sidebar starts here  -->
<div class="right-sidebar col-lg-3">

    <!--profile card Starts here  -->
    <?php include('includes/profile-card.php');?>
    <!--profile card ends here  -->

    <!-- <div class="sidebar-heading bg-white rounded m-0 pt-3 px-3">
        <a href="add.php" style="background-color: var(--primary-color); color: white;"
            class="right-sidebar-add-topic d-inline-block w-100 text-center rounded">
            Add new post
        </a>
    </div> -->
    <div class="sidebar-body bg-white rounded p-3">

        <?php if(!isLoggedIn()):?>
        <div class="sidebar-item mb-3">
            <div class="login-form">
                <form action="login.php" method="post">
                    <div class="form-group mb-3">
                        <input type="email" name="loginEmail" class="form-control add-post-input"
                            aria-describedby="emailHelp" placeholder="Email">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" name="loginPassword" class="form-control add-post-input"
                            placeholder="Password">
                    </div>
                    <button type="submit" name="doLogin" class="btn btn-primary h5 w-100">Login</button>
                </form>
            </div>
        </div>
        <?php else:?>
        <div class="sidebar-heading bg-white rounded m-0 py-3">
            <a href="add.php?uid=<?php echo $userInfo->id;?>" style="background-color: var(--primary-color); color: white;"
                class="right-sidebar-add-topic d-inline-block w-100 text-center rounded">
                Add new post
            </a>
        </div>
        <div class="sidebar-item mb-3">
            <div class="logout-form">
                <form action="logout.php" method="post">
                    <button type="submit" name="doLogout" class="btn btn-primary w-100 h6">LogOut</button>
                </form>
            </div>
        </div>

        <div class="sidebar-item mb-3">
            <div class="wishlisted-posts">
                <div class="d-flex justify-content-between">
                    <div class="wishlist-title d-flex align-items-center">
                        <i class="fa fa-book me-2" aria-hidden="true"></i>
                        <a href="<?php echo BASE_URI;?>wishlisted.php" class="m-0 h6">Wishlisted Books</a>
                    </div>
                    <div class="wishlist-post-count">
                        <div style="background-color: var(--primary-color);" class="badge badge-pill">
                            <a id="right-sidebar-wishlisted-count" href="<?php echo BASE_URI;?>wishlisted.php" style="color:white!important;"><?php echo $userWishlistCount;?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php endif;?>

    </div>
</div>

<!-- Right sidebar ends here  -->