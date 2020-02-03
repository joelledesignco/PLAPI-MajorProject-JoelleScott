<section id="login-bg">
    <div class="navbar-brand">
        <a href="/">
            <img id="main-logo" class="shadow-lg" src="../views/assets/images/puff-logo.png" alt="">
        </a>
    </div>
    <div class="container">
        <form action="/users/add.php" class="col-6 mx-auto blurry-bg p-5 mt-5 shadow-lg" method="post">
            <div class="row p-5 ">
                <div class="col">
                    <a href="/users/login.php" class="px-4 login-link pb-2">LOGIN</a>
                </div>
                <div class="col">
                    <a href="/users/signup.php" class="on px-4 login-link pb-2">SIGNUP</a>
                </div>  
            </div>
        
            <?= !empty($_SESSION['create_acc_msg']) ? $_SESSION['create_acc_msg'] : '' ?>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name" class="text-light">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name" class="text-light">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="email" class="text-light">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="username" class="text-light">Username</label>
                    <input type="username" class="form-control" id="username" name="username" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="password" class="text-light">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group ml-3">
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" name="agree_terms" id="gridCheck" required>
                        <label class="form-check-label text-light" for="gridCheck">
                            I confirm I am 19 years of age or older to enter this site.
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group mx-auto mt-y">
                    <button type="submit" value="signup" class="my-button">Signup</button>
                </div> 
            </div>  
        </form>
    </div>
</section>
