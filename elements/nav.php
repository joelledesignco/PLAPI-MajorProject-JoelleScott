

<nav class="navbar navbar-expand-lg" role="navigation">
  <div class="navbar-brand">
    <a href="/">
      <img id="main-logo" src="../views/assets/images/puff-logo.png" alt="">
    </a>
  </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">

    <?php
    // Check if user is logged in. Show welcome links
    if( $_SESSION['user_logged_in'] ){

        $u = new User;
        $user = $u->get_by_id($_SESSION['user_logged_in']);

        ?>

          <li class="nav-item dropdown mr-5">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-circle" id="user-circle"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/users/">My Profile</a>
              <hr>
              <a class="dropdown-item" href="/users/logout.php">Logout</a>
            </div>
          </li>
  <?php }else{ // user not logged in. ?>

    <?php } ?>
    </ul>
  </div>
</nav>

