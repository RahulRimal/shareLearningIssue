<!-- Chat system Strats Here -->

<?php if (isset($_SESSION['nextPerson'])) : ?>
    <div id="chat-system" class="d-block">
        <div id="chat-box" class="d-flex flex-column justify-content-between text-center bg-white">
            <div class="chat-box-heading p-2" style="background-color: var(--primary-color); border-top-left-radius: 25px; border-top-right-radius: 25px;">
                <div class="row">
                    <div class="user-pic col-2 position-relative">
                        <img src="<?php echo BASE_URI; ?>images/<?php echo $nextUserInfo->picture; ?>" class="circle-avatar-icon">
                        <div class="user-online-status">
                            <div class="user-online-active" style="position: absolute; top: 45%; left: 60%;">
                            </div>
                        </div>
                    </div>
                    <div class="user-name text-start col-8">
                        <a href="<?php echo BASE_URI;?>user-selling.php?nU=<?php echo $nextUserInfo->id;?>" class="h6"><?php echo $nextUserInfo->firstName . ' ' . $nextUserInfo->lastName; ?></a>
                        <div class="online-status-text" style="margin-top: -5px;">
                            <p class="active-now-text">Active Now</p>
                        </div>
                    </div>
                    <div class="chat-box-minimize col-2 d-flex justify-content-around" style="align-items: center;">
                    <i class="fas fa-window-minimize mb-2 hideChatBox" style="cursor: pointer;"></i>
                        <i class="fas fa-window-close closeChatBox" style="cursor: pointer;"></i>
                        <!-- <i class="fas fa-window-minimize mb-2 hideChatBox" style="cursor: pointer;" onclick="hideChatBox()"></i>
                        <i class="fas fa-window-close closeChatBox" style="cursor: pointer;" onclick="closeChatBox()"></i> -->
                    </div>
                </div>
            </div>
            <div class="chat-box-body">
                <div id="chat-content-area" class="p-2">
                    <!-- Friend Chat message starts here  -->
                    <!-- <div class="friend-message-text">
                    <div class="chat-message d-flex align-items-center mb-2">
                        <div class="chat-user-pic me-2">
                            <img src="<? //php echo BASE_URI;
                                        ?>images/Share Your Learning.png" class="circle-avatar-icon"
                                style="height: 17px; width: 17px;">
                        </div>
                        <div class="chat-text bg-primary float-left" style="border-radius: 10px; margin-right: 100px;">
                            <div class="p-1">
                                <p class="m-0 text-start">Hello there !!</p>
                            </div>
                        </div>
                    </div>
                </div> -->
                    <!-- Friend Chat message ends here  -->

                    <!-- User chat message starts here  -->
                    <!-- <div class="user-message-text">
                    <div class="chat-message d-flex flex-row-reverse align-items-center mb-2">
                        <div class="chat-user-pic ms-2">
                            <img src="<? //php echo BASE_URI;
                                        ?>images/Share Your Learning.png" class="circle-avatar-icon"
                                style="height: 17px; width: 17px;">
                        </div>
                        <div class="chat-text float-left"
                            style="border-radius: 10px; margin-left: 100px; background-color: var(--primary-color);">
                            <div class="p-1">
                                <p class="m-0 text-end">Hello there !!</p>
                            </div>
                        </div>
                    </div>
                </div> -->
                    <!-- User chat message ends here  -->
                </div>
            </div>
            <div class="chat-box-footer mb-2">
                <div class="chat-box-type-area">
                    <form id="chat-form">
                        <div class="row m-0 justify-content-between">
                            <div class="col-11 p-0">
                                <input id="senderId" type="text" value="<?php echo $_SESSION['user_id'] ?>" hidden>
                                <input id="receiverId" type="text" value="<?php echo $nextUserInfo->id ?>" hidden>
                                <input type="text" name="newMessage" id="chat-box-input" autocomplete="off" style="padding: 2px 15px;">
                            </div>
                            <div class="col-1 p-0">
                                <button id="chat-box-send-btn" type="submit" style="background: none; border: none;"><i class="fas fa-paper-plane" style="top: 10px; right: 10px; cursor:pointer"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="chat-head" class="d-block">
            <img src="<?php echo BASE_URI; ?>images/<?php echo $nextUserInfo->picture; ?>" class="chat-head-avatar" onclick="showChatBox()" style="position: fixed; bottom: 20px; right: 5%; z-index: 1030; cursor: pointer;">
        </div>
    </div>

<?php endif; ?>

<!-- Chat system Ends Here -->