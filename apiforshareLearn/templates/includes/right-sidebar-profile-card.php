<!-- Right sidebar profile card Starts here  -->

<?php if(isset($_GET['user']) || isset($_GET['post'])):?>
            <div class="right-sidebar col-lg-3 bg-white p-4 mb-5" style="max-height: 325px; border-radius: 35px;">

                <div class="sidebar-item">
                    <div class="user-info d-flex justify-content-between align-items-center">
                        <div class="user-profile-pic">
                            <img class="circle-avatar" src="<?php echo $userInfo->picture;?>" alt="">
                        </div>
                        <div class="user-info" style="width: 65%;">
                            <h6 class="user-name"><em><?php echo $userInfo->firstName;?>
                                    <?php echo $userInfo->lastName;?></em></h6>
                            <p class="user-desc text-truncate"><?php echo $userInfo->description;?></p>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="sidebar-item">
                    <div class="user-followers-rating d-flex justify-content-between">
                        <div class="user-followers-count d-flex flex-column text-center">
                            <h6>Current Followers</h6>
                            <h4 style="color: var(--primary-color);"><?php echo $followers;?></h4>
                        </div>
                        <div class="vertical-line">
                        </div>
                        <div class="user-overall-rating">
                            <div class="user-rating-count d-flex flex-column text-center">
                                <h6>Overall Rating</h6>
                                <h4 style="color: var(--primary-color);"><?php echo $userRating;?><i
                                        style="color: goldenrod;" class="fa fa-star" aria-hidden="true"></i></h4>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="sidebar-item">
                    <div class="link-with-user d-flex justify-content-around" style="cursor: pointer;">
                        <div class="follow-user d-flex flex-column align-items-center sidebar-item-red">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <p>Follow Rahul</p>
                        </div>

                        <div class="follow-user d-flex flex-column align-items-center sidebar-item-red"
                            onclick="showChatSystem()">
                            <i class="fab fa-facebook-messenger"></i>
                            <p>Message Rahul</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif;?>


<!-- Right sidebar profile card ends here  -->