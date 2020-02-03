<section id="login-bg">
    <div class="navbar-brand">
        <a href="/">
            <img id="main-logo" class="shadow-lg" src="../views/assets/images/puff-logo.png" alt="">
        </a>
    </div>
    <div class="container">
        <form action="/users/login.php" class="col-6 mx-auto blurry-bg p-5 mt-5 shadow-lg" method="post">
            <div class="row p-5 mx-auto">
                <div class="col">
                    <a href="/users/login.php" class="px-4 login-link pb-2 active">LOGIN</a>
                </div>
                <div class="col">
                    <a href="/users/signup.php" class="on px-4 login-link pb-2">SIGNUP</a>
                </div>  
            </div>
            <?=!empty($_SESSION['login_attempt_msg']) ? $_SESSION['login_attempt_msg'] : '' ?>

            <div class="form-group">
                <label for="username" class="text-light">Username</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="password" class="text-light">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group mt-5">
                <p>
                    <button type="submit" name="action" value="submit" class="my-button mx-auto">Login</button>
                </p>
            </div>
        </form>
    </div>
</section>
