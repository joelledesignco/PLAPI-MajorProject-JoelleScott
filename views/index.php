<?php  require_once("../core/includes.php");
    // unique html head vars
    $title = 'Home Page';
    require_once("../elements/html_head.php");

    if( empty($_SESSION['user_logged_in']) ){ // user not logged in
        // Show login/signup forms
        if(isset($_GET['signup'])){ 
            require_once '../elements/signup-form.php';

        } else {
            require_once '../elements/login-form.php';
        }
    }else{ 
        require_once("../elements/nav.php");// user is logged in 
?>

    <div id="feed-banner">
      <div class="container">
        <div class="col-7 banner-content">
            <h1 class="banner-text">Guiding you on your</h1>
            <h1 class="banner-text">personal journey</h1>
            <h1 class="banner-text">with cannabis</h1>
        </div>
      </div>
    </div>

    <div class="angle-box">
        <div class="angle-title">
            <a href="add_strain.php"><i class="fas fa-plus-circle"></i> Add Strain</a>
        </div>
    </div>


    <div class="container my-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-11 mx-auto" id="feed-col">

                <?php // Search Bar ?>

                <form action="/" method="get">
                    <div class="form-group input-group md-form form-sm form-2 pl-0" id="searchArea">
                        <input type="text" name="search" class="form-control my-0 py-1 red-border" type="text" placeholder="Search" aria-label="Search">
                        <button class="my-button2" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                
                <div class="row my-5" id="project-feed">
                    
                <?php
                $p = new Project;
                $projects = $p->get_all();

                $c = new Comment;

                foreach($projects as $project){
                ?>

                <!------FEED------>
                    <div class="col-md-4">
                        <div class="card" data-toggle="modal" data-target="#myModal_<?=$project['id']?>">
                            <img class="img-fluid" id="myImg" src="/assets/files/<?=$project['filename']?>">
                            <div class="card-body">
                                <h5 class="modal-title"><?=$project['title']?></h5>
                            </div>
                        </div>
                    </div>

                <!------MODAL----->
                    <div id="myModal_<?=$project['id']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="project-post modal-dialog modal-lg" id="modal-project" role="document" data-projectID="<?=$project['id']?>">
                            <div class="row" id="modal-row">
                                <div class="col-md-6"> 
                                    <img class="img-fluid" src="/assets/files/<?=$project['filename']?>">
                                    <p>Post by <a href="/users?id=<?=$project['user_id']?>"><?=$project['username']?></a></p>
                                    <p><?=date('M. d, Y h:i a', $project['posted_time'])?></p>
                                </div>
                                <div class="col-md-6">
                        
                                    <h3 class="modal-title"><?=$project['title']?></h3>
                                    <span class="float-right" id="close">
                                        <a href="/" type="button" data-dismiss="modal"><i class="fas fa-times-circle"></i></a>
                                    </span>
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
                                    <div class="my-hr"></div>
                               
                                    <div class="modal-body">
                                        <p><?=$project['category']?></p>
                                        <p><?=$project['description']?></p>
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
                                    </div>
                                </div> <!--col-6 -->
                            </div> <!-- row -->
                        </div> <!-- project post -->
                    </div> <!-- modal -->
                <?php } // end foreach ?>
                </div> <!-- row -->
            </div> <!-- col-10 -->
        </div><!-- .row -->
    </div> <!-- container -->
    <?php
    require_once("../elements/footer.php"); 
    }
    ?>

