<?php
require_once '../../core/includes.php';

$u = new User;

if( !empty($_POST) ){ // Form was submitted
    $u->edit();
    header('Location: /users/');
    exit();
}

$user = $u->get_by_id($_SESSION['user_logged_in']);

$title = 'Edit Profile';
require_once '../../elements/html_head.php';
require_once '../../elements/nav.php';

?>

<div id="feed-banner" class="mb-5">
    <div class="container">
        <div class="banner-content2">
            <h1 class="banner-text3">Edit Profile</h1>
            <div class="my-hr"></div>
            <form id="edit-prof" method="post" enctype="mulipart/form-data" class="col-6 blurry-bg p-5 mt-5 shadow-lg">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name" class="text-light">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?=$user['firstname']?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name" class="text-light">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?=$user['lastname']?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="email" class="text-light">Email</label>
                        <input type="email" class="form-control" id="inputEmail4" name="email" value="<?=$user['email']?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="username" class="text-light">Username</label>
                        <input type="username" class="form-control" id="username" name="username" value="<?=$user['username']?>" required>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <input class="my-button3 mx-auto" type="submit" value="Submit">
                </div>
            </form>           
        </div><!-- row -->
    </div><!-- container -->
</div><!-- banner -->

<?php require_once '../../elements/footer.php';
