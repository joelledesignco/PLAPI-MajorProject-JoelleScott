<?php require_once '../../core/includes.php';

header("Content-Type: application/json");

$comment_data = array(
    'error' => true
);

if( !empty($_POST['comment_id']) ){

    $c = new Comment;
    $comment_data = $c->delete($comment_data);

    $comment_data['error'] = false;

}

echo json_encode($comment_data);
