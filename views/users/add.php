<?php
require_once '../../core/includes.php';

if( !empty($_POST['firstname']) && 
    !empty($_POST['lastname']) && 
    !empty($_POST['email']) && 
    !empty($_POST['username']) && 
    !empty($_POST['password']) ){

    $u = new User;

    // Check if username already exists
    $exists = $u->exists();

    if( empty($exists) ){ // User does not exist
        $new_user_id = $u->add();
        $_SESSION['user_logged_in'] = $new_user_id;

    }else{
        $_SESSION['create_acc_msg'] = '<p class="text-danger">* Username already exists</p>';
    }
}

if(!APP_DEBUG) header("Location: /");

?>
