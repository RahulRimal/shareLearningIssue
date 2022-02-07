
<?php
require('core/init.php');
?>

<?php

$template = new Template('templates/add-post.php');

$messages = new Chat();

if (isset($_POST['sender']) && isset($_POST['receiver'])) {
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];

    if ($messages->sendMessage($sender, $receiver, $message)) {
        $row = $messages->getMessage($sender, $receiver);

        if ($row->outgoing_id == $_SESSION['user_id']) {
            echo '<!-- User chat message starts here  -->
        <div class="user-message-text">
            <div class="chat-message d-flex flex-row-reverse align-items-center mb-2">
                <div class="chat-user-pic ms-2">
                    <img src="' . BASE_URI . 'images/' . $row->picture . '" class="circle-avatar-icon"
                        style="height: 17px; width: 17px;">
                </div>
                <div class="chat-text float-left"
                    style="border-radius: 10px; margin-left: 100px; background-color: var(--primary-color);">
                    <div class="p-1">
                        <p class="m-0 text-end">' . $row->message . '</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- User chat message ends here  -->';
            die();
        } else {
            // if(!isset($_SESSION['nextPerson']))
            // {
            //     $_SESSION['nextPerson'] = $row->outgoing_id;
            // }
            echo '<!-- Friend Chat message starts here  -->
                <div class="friend-message-text">
                    <div class="chat-message d-flex align-items-center mb-2">
                        <div class="chat-user-pic me-2">
                        <img src="' . BASE_URI . 'images/' . $row->picture . '" class="circle-avatar-icon"
                                style="height: 17px; width: 17px;">
                        </div>
                        <div class="chat-text bg-primary float-left" style="border-radius: 10px; margin-right: 100px;">
                            <div class="p-1">
                                <p class="m-0 text-start">' . $row->message . '</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Friend Chat message ends here  -->';
            die();
        }
    }
}


if (isset($_POST['sender_id']) && isset($_POST['receiver_id'])) {
    $sender = $_POST['sender_id'];
    $receiver = $_POST['receiver_id'];

    // $first = true;

    // if($first)
    // {
    //     $rows = $messages->getAllMessages($sender, $receiver);
    //     $first = false;
    // }
    
    // else
    //     $row = $messages->getMessage($sender, $receiver);

    // $rows = $messages->getMessage($sender, $receiver);
    // $row = $messages->getMessage($sender, $receiver);
    $rows = $messages->getAllMessages($sender, $receiver);

    foreach ($rows as $row) {
        if ($row->outgoing_id == $_SESSION['user_id']) {
            echo '<!-- User chat message starts here  -->
                <div class="user-message-text">
                    <div class="chat-message d-flex flex-row-reverse align-items-center mb-2">
                        <div class="chat-user-pic ms-2">
                        <!-- <img src="' . BASE_URI . 'images/' . $row->picture . '" class="circle-avatar-icon"
                                style="height: 17px; width: 17px;"> -->
                        </div>
                        <div class="chat-text float-left"
                            style="border-radius: 10px; margin-left: 100px; background-color: var(--primary-color); overflow-wrap: anywhere!important;">
                            <div class="p-1">
                                <p class="m-0 text-end">' . $row->message . '</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User chat message ends here  -->';
        } else {
            echo '<!-- Friend Chat message starts here  -->
                <div class="friend-message-text">
                    <div class="chat-message d-flex align-items-center mb-2">
                        <div class="chat-user-pic me-2">
                        <img src="' . BASE_URI . 'images/' . $row->picture . '" class="circle-avatar-icon"
                                style="height: 17px; width: 17px;">
                        </div>
                        <div class="chat-text bg-primary float-left" style="border-radius: 10px; margin-right: 100px; overflow-wrap: anywhere!important;">
                            <div class="p-1">
                                <p class="m-0 text-start">' . $row->message . '</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Friend Chat message ends here  -->';
        }
    }
}



// echo $template;

?>