<!-- profile card Starts here  -->

<?php if (isset($_GET['user']) || isset($_GET['post'])) : ?>
    <div class="bg-white p-4 mb-5" style="max-height: 325px; border-radius: 35px;">

        <div class="sidebar-item">
            <div class="user-info d-flex justify-content-between align-items-center">
                <div class="user-profile-pic">
                    <img style="height: 60px; width: 60px;" class="circle-avatar" src="<?php echo BASE_URI; ?>images/<?php echo $nextUserInfo->picture; ?>">
                </div>
                <div class="user-info" style="width: 65%;">
                    <h6 class="user-name"><em><?php echo $nextUserInfo->firstName; ?>
                            <?php echo $nextUserInfo->lastName; ?></em></h6>
                    <p class="user-desc text-truncate"><?php echo $nextUserInfo->description; ?></p>
                </div>
            </div>
            <hr>
        </div>
        <div class="sidebar-item">
            <div class="user-followers-rating d-flex justify-content-between">
                <div class="user-followers-count d-flex flex-column text-center">
                    <h6>Current Followers</h6>
                    <h4 class="user-followers-count-text" style="color: var(--primary-color);"><?php echo $followers; ?></h4>
                </div>
                <div class="vertical-line">
                </div>
                <div class="user-overall-rating">
                    <div class="user-rating-count d-flex flex-column text-center">
                        <h6>Overall Rating</h6>
                        <h4 style="color: var(--primary-color);"><?php echo $userRating; ?><i style="color: goldenrod;" class="fa fa-star" aria-hidden="true"></i></h4>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="sidebar-item">
            <?php if (isLoggedIn()) : ?>
                <div class="link-with-user d-flex justify-content-around" style="cursor: pointer;">
                    <?php if (isFollowing($_SESSION['user_id'], $nextUserInfo->id)) : ?>
                        <div class="unfollow-user d-flex flex-column align-items-center sidebar-item-red text-center">
                            <input id="unfollowerId" type="text" value="<?php echo $_SESSION['user_id']; ?>" hidden>
                            <input id="unfollowedId" type="text" value="<?php echo $nextUserInfo->id; ?>" hidden>
                            <i class="unfollow-user-icon fa fa-user-times" aria-hidden="true"></i>
                            <a>
                                <p id="unfollow-user-btn" class="unfollow-user-btn" onclick="removeFollower(<?php echo $_SESSION['user_id']?>, <?php echo $nextUserInfo->id?>, this)">Unfollow <?php echo $nextUserInfo->firstName; ?></p>
                            </a>
                        </div>
                        <div id="openChatSystem" class="follow-user d-flex flex-column align-items-center sidebar-item-red text-center" onclick="showChatSystem()">
                            <i class="fab fa-facebook-messenger"></i>
                            <p>Message <?php echo $nextUserInfo->firstName; ?></p>
                        </div>
                    <?php elseif (!isSameUser($_SESSION['user_id'], $nextUserInfo->id)) : ?>
                        <div class="follow-user d-flex flex-column align-items-center sidebar-item-red text-center">
                            <input id="followerId" type="text" value="<?php echo $_SESSION['user_id']; ?>" hidden>
                            <input id="followedId" type="text" value="<?php echo $nextUserInfo->id; ?>" hidden>
                            <i class="follow-user-icon fa fa-user-plus" aria-hidden="true"></i>
                            <a>
                                <p id="follow-user-btn" class="follow-user-btn" onclick="addFollower(<?php echo $_SESSION['user_id']?>, <?php echo $nextUserInfo->id?>, this)">Follow <?php echo $nextUserInfo->firstName; ?></p>
                            </a>
                        </div>
                        <div id="openChatSystem" class="follow-user d-flex flex-column align-items-center sidebar-item-red text-center" onclick="showChatSystem()">
                            <i class="fab fa-facebook-messenger"></i>
                            <p>Message <?php echo $nextUserInfo->firstName; ?></p>
                        </div>
                        <!-- </div> -->

                        <!-- <div class="follow-user d-flex flex-column align-items-center sidebar-item-red text-center" onclick="showChatSystem()">
                            <i class="fab fa-facebook-messenger"></i>
                            <p>Message <? //php echo $nextUserInfo->firstName; 
                                        ?></p>
                        </div> -->
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <p style="color: var(--primary-color);" class="h6 text-center">Please <a class="text-primary" href="#">Log In</a> to message this user</p>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>


<!--profile card ends here  -->