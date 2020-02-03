<?php

class Project extends Db {

    public function get_all(){

        $user_id = (int)$_SESSION['user_logged_in'];

        if( !empty($_GET['search']) ){ // They're searching something
            $search = $this->params['search'];

            $sql = "SELECT  projects.*, 
                            users.username, users.firstname, users.lastname, 
                            loves.id AS love_id, 
                            (SELECT COUNT(loves.id) FROM loves WHERE loves.project_id = projects.id) AS love_count
            FROM projects
            LEFT JOIN users
            ON projects.user_id = users.id
            LEFT JOIN loves
            ON projects.id = loves.project_id
            AND loves.user_id = '$user_id'
            WHERE projects.title LIKE '%$search%' OR projects.category OR CONCAT(users.username) LIKE '%$search%' ORDER BY projects.posted_time DESC";

        } else{ // They're not searching
            $sql = "SELECT
            projects.*, users.username, loves.id AS love_id,
            (SELECT COUNT(loves.id) FROM loves WHERE loves.project_id = projects.id) AS love_count
            FROM projects
            LEFT JOIN users
            ON projects.user_id = users.id
            LEFT JOIN loves
            ON projects.id = loves.project_id
            AND loves.user_id = '$user_id'
            ORDER BY projects.posted_time DESC";
        }

        $projects = $this->select($sql);
        return $projects;
    }


    

    function get_by_id($id){
        $id = (int)$id;
        $sql = "SELECT * FROM projects WHERE id = '$id'";
        $project = $this->select($sql)[0];
        return $project;
    }

    function get_by_user_id($user_id){
        $id = (int)$id;
        $sql = "SELECT * FROM projects WHERE user_id = '$user_id'";
        $projects = $this->select($sql);
        return $projects;
    }

    function add(){

        $title = $this->data['title'];
        $category = $this->data['category'];
        $description = $this->data['description'];
        $user_id = (int)$_SESSION['user_logged_in'];

        $util = new Util;

        $file_upload = $util->file_upload();
        $filename = $file_upload['filename'];
        $current_time = time();

        if( $file_upload['file_upload_error_status'] === 0 ){ // File upload was successful
            $sql = "INSERT INTO projects (title, category, description, filename, posted_time, user_id) 
                    VALUES ('$title', '$category', '$description', '$filename', '$current_time', '$user_id')";
            $this->execute($sql);
        }
    }

    function edit($id){

        $id = (int)$id;
        $this->check_ownership($id); // Make sure user owns post that's being editted

        $title = $this->data['title'];
        $category = $this->data['category'];
        $description = $this->data['description'];
        $current_user_id = (int)$_SESSION['user_logged_in'];

        if( !empty($_FILES['fileToUpload']['name']) ) { // Check if new file submitted

            $util = new Util;
            $file_upload = $util->file_upload(); // Upload new file
            $filename = $file_upload['filename'];

            if( $file_upload['file_upload_error_status'] === 0 ){ // File upload was successful

                // Get old filename from db first
                $old_project_image = trim($this->get_by_id($id)['filename']);

                // Save filename to DB
                $sql = "UPDATE projects SET title='$title', category='$category', description='$description', filename='$filename' WHERE id='$id' AND user_id='$current_user_id'";

                $this->execute($sql);

                // Delete the old project image file
                if( !empty($old_project_image) ){
                    if( file_exists(APP_ROOT.'/views/assets/files/'.$old_project_image )){
                        unlink( APP_ROOT.'/views/assets/files/'.$old_project_image );
                    }
                }
            }

        }else{ // if no new file was submitted
            $sql = "UPDATE projects SET title='$title', category='$category', description='$description' WHERE id='$id' AND user_id='$current_user_id'";

            $this->execute($sql);
        }
    }

    function delete(){

        $current_user_id = (int)$_SESSION['user_logged_in'];
        $id = (int)$_GET['id'];
        $this->check_ownership($id);

        // Delete the old project image file
        $project_image = trim($this->get_by_id($id)['filename']);
        if( !empty($project_image) ){
            if( file_exists(APP_ROOT.'/views/assets/files/'.$project_image )){
                unlink( APP_ROOT.'/views/assets/files/'.$project_image );
            }
        }

        $sql = "DELETE FROM projects WHERE id='$id' AND user_id='$current_user_id'";
        $this->execute($sql);

    }

    function check_ownership($id){

        $id = (int)$id;

        $sql = "SELECT * FROM projects WHERE id = '$id'";

        $project = $this->select($sql)[0];

        if( $project['user_id'] == $_SESSION['user_logged_in'] ){
            return true;
        }else{
            header("Location: /");
            exit();
        }
    }
}
