<?php
class Comment extends Db {

    function get_all_by_project_id($project_id){

        $user_id = $_SESSION['user_logged_in'];
        $project_id = (int)$project_id;

        $sql = "SELECT comments.*, users.username,
        IF(comments.user_id = '$user_id', 'true', 'false') AS user_owns
        FROM comments LEFT JOIN users ON comments.user_id = users.id
        WHERE project_id='$project_id'
        ORDER BY posted_time DESC LIMIT 5
        ";

        $all_project_comments = $this->select($sql);

        return $all_project_comments;

    }

    function get_count($project_id){
        $project_id = (int)$project_id;

        $sql = "SELECT COUNT(id) AS comment_count FROM comments WHERE project_id = '$project_id'";

        $comment_count = $this->select($sql)[0];
        return $comment_count['comment_count'];

    }

    function add($comment_data){

        $comment = $this->data['comment'];
        $project_id = $this->data['project_id'];
        $user_id = (int)$_SESSION['user_logged_in'];
        $posted_time = time();

        $sql = "INSERT INTO comments (comment, project_id, user_id, posted_time)
                VALUES('$comment', '$project_id', '$user_id', '$posted_time')
        ";

        // Check if inserted successfully
        $comment_id = $this->execute_return_id($sql);
        if( !empty($comment_id) ){
            if( $comment_id != 0 && is_numeric($comment_id) ){
                $comment_data['error'] = false;
            }
        }

        // Get comment count total
        $comment_count = $this->get_count($project_id);
        $comment_data['comment_count'] = $comment_count;

        // Return all comments for project
        $all_project_comments = $this->get_all_by_project_id($project_id);
        $comment_data['comments'] = $all_project_comments;

        return $comment_data;
    }

    function delete($comment_data){

        $comment_id = (int)$this->data['comment_id'];
        $project_id = (int)$this->data['project_id'];

        $sql = "DELETE FROM comments WHERE id = '$comment_id'";
        $this->execute($sql);

        // Get comment count total
        $comment_count = $this->get_count($project_id);
        $comment_data['comment_count'] = $comment_count;

        return $comment_data;

    }

}
