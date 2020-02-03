<?php require_once '../../core/includes.php';
header("Content-Type: application/json");
$comment_data = array(
    'error' => true
);

if( !empty($_POST['project_id']) ){ // Comment form submitted, project id present

    // Add new comment to db
    $c = new Comment;
    $comment_data = $c->add($comment_data);

}

echo json_encode($comment_data);
die();