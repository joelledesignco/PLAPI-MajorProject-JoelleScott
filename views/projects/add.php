<?php require_once '../../core/includes.php';

if( !empty($_POST['title']) && !empty($_POST['category']) && !empty($_POST['description']) ){ // Form was submitted

    // Add new project to db
    $p = new Project;
    $p->add();

}

header("Location: /");

