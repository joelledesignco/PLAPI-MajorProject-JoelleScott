<?php  require_once("../../core/includes.php");

    if( !empty($_GET) ){ // Check url has id in it

        $p = new Project;
        $project = $p->get_by_id($_GET['id']);

        if( !empty($_POST) ){ // Check if form was submitted
            $p->edit($_GET['id']);
            header("Location: /");
            exit();
        }

    }else{
        header("Location: /");
        exit();
    }


    // unique html head vars
    $title = 'Edit Project';
    require_once("../../elements/html_head.php");
    require_once("../../elements/nav.php");

?>

    <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card border-success mt-3">
                        <div class="card-header">
                            <h4>Edit Project:</h4>
                        </div><!-- .card-header -->
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <img id="img-preview" src="/assets/files/<?=$project['filename']?>">
                                <div class="form-group">
                                    <input id="file-with-preview" type="file" name="fileToUpload" onchange="previewFile()">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="title" placeholder="Project Title:" value="<?=$project['title']?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="category" placeholder="Strain Category" value="<?=$project['category']?>" required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" placeholder="Project Description:" required><?=$project['description']?></textarea>
                                </div>
                                <input class="btn btn-primary" type="submit" value="Submit">
                            </form>
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                </div><!-- .col-md-8 -->
            </div><!-- .row -->
    </div><!-- .container -->

<?php require_once("../../elements/footer.php");
