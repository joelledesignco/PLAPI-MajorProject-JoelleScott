<?php
require_once '../../core/includes.php';

$u = new User;

$user = $u->get_by_id($_SESSION['user_logged_in']);


$title = 'My Profile';
require_once '../../elements/html_head.php';
require_once '../../elements/nav.php';

//check if id is set, if it is, get user by id and pass data
///else load current user
if(!empty($_GET['id'])) {
    $user_id = $_GET['id'];
    $u_model = new User;
    $selected_user = $u_model->get_by_id($user_id);
} else {
    $selected_user = $user;
}

?>

<div id="feed-banner" class="mb-5">
    <div class="container">    
        <div class="col-7 banner-content2">
            <h1 class="banner-text2"><?=$selected_user['username']?>'s Profile
                <?php
                if( $selected_user['id'] == $_SESSION['user_logged_in'] ){ ?>
                <span class="float-right">
                    <a href="/users/edit.php?id=<?=$selected_user['id']?>">
                        <i class="far fa-edit" aria-hidden="true"></i>
                    </a>
                </span>
                <?php
                }
                ?>
            </h1>
            <div class="my-hr"></div>
            <div class="profile">
                <label for="username">Username</label>
                <h6><?=$selected_user['username']?></h6>
                <label for="email">Email</label>
                <h6><?=$selected_user['email']?></h6>
                <label for="firstname">Firstname</label>
                <h6><?=$selected_user['firstname']?></h6>
                <label for="lastname">Lastname</label>
                <h6><?=$selected_user['lastname']?></h6>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-11 mx-auto" id="feed-col">
                <h1 class="banner-text2"><?=$selected_user['username']?>'s Strains</h1>
                <div class="my-hr"></div>
    

                <div class="row my-5" id="project-feed">
                    
  

                <?php
                // get all projects by this user
                $p_model = new Project;
                $user_projects = $p_model->get_by_user_id($selected_user['id']);
                foreach($user_projects as $user_project) {

                ?>


                <!------FEED------>
                    <div class="col-md-4">
                        <div class="card" data-toggle="modal" data-target="#myModal_<?=$user_project['id']?>">
                            <img class="img-fluid" id="myImg" src="/assets/files/<?=$user_project['filename']?>">
                            <div class="card-body">
                                <h5 class="modal-title"><?=$user_project['title']?></h5>
                            </div>
                        </div>
                    </div>

                <!------MODAL----->
                    <div id="myModal_<?=$user_project['id']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="project-post modal-dialog modal-lg" id="modal-project" role="document" data-projectID="<?=$user_project['id']?>">
                            <div class="row" id="modal-row">
                                <div class="col-md-6"> 
                                    <img class="img-fluid" src="/assets/files/<?=$user_project['filename']?>">
                                    <p>Post by <a href="/users?id=<?=$user_project['user_id']?>"><?=$user_project['username']?></a></p>
                                    <p><?=date('M. d, Y h:i a', $user_project['posted_time'])?></p>
                                </div>
                                <div class="col-md-6">
                        
                                    <h3 class="modal-title"><?=$user_project['title']?></h3>
                                    <span class="float-right" id="close">
                                        <a href="/" type="button" data-dismiss="modal"><i class="fas fa-times-circle"></i></a>
                                    </span>
                                    <?php
                                    if( $user_project['user_id'] == $_SESSION['user_logged_in'] ){ ?>
                                        <span class="float-right">
                                            <a href="/projects/edit.php?id=<?=$user_project['id']?>">
                                                <i class="far fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <a class="delete-btn text-danger" href="/projects/delete.php?id=<?=$user_project['id']?>">
                                                <i class="far fa-trash-alt" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                    <div class="my-hr"></div>
                               
                                    <div class="modal-body">
                                        <p><?=$user_project['category']?></p>
                                        <p><?=$user_project['description']?></p>
                                        <div class="border-bottom pb-3">
                                            <span class="float-left">
                                                <i class="fas fa-heart text-danger"></i>
                                                <span class="loves-count"><?=$user_project['love_count']?></span>
                                            </span>
                                            <span class="float-right comment-count-btn">
                                                <i class="far fa-comment"></i>
                                                <span class="comment-count"><?=$c->get_count($user_project['id'])?></span>
                                            </span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="pt-3">
                                            <?php
                                            $love_class = 'far';
                                            $love_text = 'Love it';
                                            if( !empty($user_project['love_id']) ){ // They loved it
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
                                            $comments = $c->get_all_by_project_id($user_project['id']);
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













<?php require_once '../../elements/footer.php';

?>

