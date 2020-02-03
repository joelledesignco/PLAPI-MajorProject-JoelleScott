<?php  require_once("../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../elements/html_head.php");

    if( empty($_SESSION['user_logged_in']) ){ // user not logged in
        // Show login/signup forms
        require_once '../elements/login-form.php';
    }else{ 
        require_once("../elements/nav.php");// user is logged in 
?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card border-success mt-3">
                    <div class="card-header">
                        <h4>Share New Project:</h4>
                    </div><!-- .card-header -->
                    <div class="card-body">
                        <form action="/projects/add.php" method="post" enctype="multipart/form-data">
                            <img id="img-preview">
                            <div class="form-group">
                                <input id="file-with-preview" type="file" name="fileToUpload" onchange="previewFile()" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="title" placeholder="Project Title:" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="category" placeholder="Strain Category" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="description" placeholder="Project Description:" required></textarea>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Submit">
                        </form>
                    </div><!-- .card-body -->
                </div><!-- .card -->
                <div id="project-feed">

                    <?php
                    $p = new Project;
                    $projects = $p->get_all();

                    $c = new Comment;

                    foreach($projects as $project){
                    ?>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4><a href="/users?id=<?=$project['user_id']?>"><?=$project['firstname'] . ' ' . $project['lastname']?>
                                <?php
                                if( $project['user_id'] == $_SESSION['user_logged_in'] ){ ?>
                                    <span class="float-right">
                                        <a href="/projects/edit.php?id=<?=$project['id']?>">
                                            <i class="far fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a class="delete-btn text-danger" href="/projects/delete.php?id=<?=$project['id']?>">
                                            <i class="far fa-trash-alt" aria-hidden="true"></i>
                                        </a>
                                    </span>

                                <?php
                                }
                                ?>

                            </a></h4>
                        </div><!-- .card-header -->

                        <div class="card-body project-post" data-projectID="<?=$project['id']?>">
                            <img class="img-fluid" src="/assets/files/<?=$project['filename']?>">
                            <br><br>
                            <h5><?=$project['title']?></h5>
                            <h6><?=$project['category']?></h6>
                            <p><?=$project['description']?></p>

                            <p>Posted on: <?=date('M. d, Y h:i a', $project['posted_time'])?></p>

                            <div class="border-bottom pb-3">

                                <span class="float-left">
                                    <i class="fas fa-heart text-danger"></i>
                                    <span class="loves-count"><?=$project['love_count']?></span>
                                </span>

                                <span class="float-right comment-count-btn">
                                    <i class="far fa-comment"></i>
                                    <span class="comment-count"><?=$c->get_count($project['id'])?></span>
                                </span>

                                <div class="clearfix"></div>
                            </div>

                            <div class="pt-3">

                                <?php
                                $love_class = 'far';
                                $love_text = 'Love it';
                                if( !empty($project['love_id']) ){ // They loved it
                                    $love_class = 'fas';
                                    $love_text = 'Loved!';
                                }
                                ?>

                                <span class="love-btn float-left">
                                    <i class="<?=$love_class?> fa-heart love-icon text-danger"></i>
                                    <span class="love-btn-text"><?=$love_text?></span>
                                </span>
                                <span class="float-right comment-btn">
                                    <i class="far fa-comment"></i> Comment
                                </span>
                                <div class="clearfix"></div>
                            </div>

                            <div class="comment-loop">

                                <?php
                                $comments = $c->get_all_by_project_id($project['id']);

                                foreach($comments as $comment){
                                ?>

                                <div class="user-comment">
                                    <?php
                                    if($comment['user_owns'] === 'true'){
                                    ?>
                                        <i class="fas fa-times-circle delete-comment-btn" data-commentID="<?=$comment['id']?>"></i>
                                    <?php } ?>
                                    <p>
                                        <span class="font-weight-bold comment-username"><?=$comment['username']?></span>
                                        <?=$comment['comment']?>
                                    </p>
                                </div><!-- .user-comment -->
                            <?php } ?>

                            </div><!-- .comment-loop -->

                            <form class="comment-form">
                                <input class="form-control commentForm-commentbox" type="text" name="comment" placeholder="Write a comment...">
                            </form>
                        </div><!-- .card-body -->
                    </div><!-- .card -->
                    <?php } // end foreach ?>
                </div><!-- #project-feed -->
            </div><!-- .col-md-8 -->
            <div class="col-md-4">
                <?php // Search Bar ?>

                <div class="mt-3 mb-3">
                    <h4>Search Projects</h4>
                    <div class="list-group">
                        <div class="list-group-item">

                            <form action="/" method="get">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" name="search">
                                </div>
                                <input type="submit" value="Submit">
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- .col-md-4 -->
        </div><!-- .row -->
    </div><!-- .container -->

    <?php
    require_once("../elements/footer.php"); 
    }
    ?>




