<?php require('core/init.php');?>

<?php

    if(isset($_POST['doLogout']))
    {
        $user = new User();

        if($user->logout())
            redirect('index.php', 'You have been logged out !!', 'success');
        
        else
            redirect('index.php','Failed to log you out !!', 'error');

    }
    else
    {
        redirect('index.php');
    }

?>