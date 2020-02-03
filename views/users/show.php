<?php
require_once '../../core/includes.php';

$u = new User;

$user = $u->get_by_id($_SESSION['user_logged_in']);
echo "<pre>";
print_r($user); 
         
?>

