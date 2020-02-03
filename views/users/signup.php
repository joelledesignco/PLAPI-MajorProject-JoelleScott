<?php  require_once("../../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../../elements/html_head.php");

    if( empty($_SESSION['user_logged_in']) ){ // user not logged in
        // Show login/signup forms
        require_once '../../elements/signup-form.php';

    }
    ?>