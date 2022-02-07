<!-- Left Sidebar Starts Here -->

<div class="left-sidebar d-flex flex-column justify-content-start text-center bg-white p-3 mb-5 col-lg-3" style="height: fit-content;">

<?php if(isset($_GET['nU'])) : ?>
        <div class=" sidebar-item user-profile-info">
            <div class="pic-name text-center">
                <img class="circle-avatar p-1 mt-5" src="<?php echo BASE_URI; ?>images/<?php echo $userInfo->picture; ?>" alt="">
                <div class="user-info">
                    <h6 class="user-name"><em><?php echo $userInfo->firstName; ?> <?php echo $userInfo->lastName; ?></em></h6>
                    <p class="user-desc text-truncate"><?php echo $userInfo->description; ?></p>
                </div>
            </div>
            <hr class="m-0">
        </div>
<?php elseif (isLoggedIn()) : ?>
        <div class=" sidebar-item user-profile-info">
            <div class="pic-name text-center">
                <img class="circle-avatar p-1 mt-5" src="<?php echo BASE_URI; ?>images/<?php echo $userInfo->picture; ?>" alt="">
                <div class="user-info">
                    <h6 class="user-name"><em><?php echo $userInfo->firstName; ?> <?php echo $userInfo->lastName; ?></em></h6>
                    <p class="user-desc text-truncate"><?php echo $userInfo->description; ?></p>
                </div>
            </div>
            <hr class="m-0">
        </div>

        <div class="sidebar-item">
            <div class="onsale-count">
                <a href="<?php echo BASE_URI; ?>user-selling.php">On Sale<br><span><strong><?php echo userPostsCount(); ?></strong></span></a>
            </div>
            <hr class="m-0">
        </div>
        <div class="sidebar-item">
            <div class="buying-count">
                <a href="<?php echo BASE_URI; ?>wishlisted.php">Wishlisted<br><span><strong id="left-sidebar-wishlisted-count"><?php echo $userWishlistCount; ?></strong></span></a>
            </div>
            <hr class="m-0">
        </div>
    <?php endif; ?>

</div>

<!-- Left Sidebar Ends Here -->