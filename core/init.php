<?php
// For functionality like checking if a user is an admin before page is loaded
if( empty($_SESSION['user_logged_in']) ){ // if not logged in


    // Allowed logged out functionality
    $allowed_urls = array(
        '/',
        '/users/signup.php',
        '/users/login.php',
        '/users/add.php',
    );

    $allowed = false;

    foreach($allowed_urls as $allowed_url){

        if( $_SERVER['REQUEST_URI'] == $allowed_url ){
            $allowed = true;
            break;
        }
    }

    if( $allowed === false ){
        header("Location: /");
    }


}else{ // User is logged in

    // Set user's Timezone
    $u = new User;
    $user = $u->get_by_id($_SESSION['user_logged_in']);

}
