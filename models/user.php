<?php
class User extends Db {

    public function get_by_id($id){
        $id = (int)$id;
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $user = $this->select($sql)[0];
        return $user;
    }

    public function add(){
        $firstname = trim($this->data['firstname']);
        $lastname = trim($this->data['lastname']);
        $email = trim($this->data['email']);
        $username = trim($this->data['username']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (firstname, lastname, username, email, password) 
                VALUES ('$firstname', '$lastname', '$username', '$email' '$password')";

        $new_user_id = $this->execute_return_id($sql);

        return $new_user_id;
    }

    public function exists(){
        if(APP_DEBUG) echo 'exists()<br>';

        $username = $this->data['username'];
        $email = $this->data["email"];
        $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
        $user = $this->select($sql);
        return $user;
    }


    public function login(){

        $_SESSION = array(); // Empty session to start fresh.

        // Get the user's details from the db and store it in a variable
        $username = $this->data['username'];
        $sql = "SELECT * FROM users WHERE username = '$username'";

        $user = $this->select($sql)[0];

        // Check if the password from the form matches password from db
        if( password_verify($_POST['password'], $user['password']) ){

            $_SESSION['user_logged_in'] = $user['id'];

        }else{ // Login attempt failed.
            $_SESSION['login_attempt_msg'] = '<p class="text-danger">* Incorrect username and/or password</p>';
        }
    }


    public function edit(){

        $id = (int)$_SESSION['user_logged_in'];
        $firstname = trim($this->data['firstname']);
        $lastname = trim($this->data['lastname']);
        $email = trim($this->data['email']);
        $username = trim($this->data['username']);
        $password = password_hash(trim($this->data['password']), PASSWORD_DEFAULT);


        if( !empty(trim($_POST['password'])) ){ // New password entered

            $sql = "UPDATE users 
                    SET firstname='$firstname', lastname='$lastname', email='$email', username='$username', password='$password' 
                    WHERE id='$id'";

        }else { // No new password entered
            $sql = "UPDATE users 
                    SET firstname='$firstname', lastname='$lastname', email='$email', username='$username'
                    WHERE id='$id'";
        }

        $this->execute($sql);
    }
}