

    <?php
        include_once "common/base.php";
        include_once "common/header.php";
        if(!empty($_SESSION['logged_in']) && !empty($_SESSION['email'])) {
    ?>
        <p>You are currently <strong>logged in</strong>.
        <p><a href="logout.php">Log out</a>

    <?php
        //} elseif(!empty($_POST['email']) && !empty($_POST['password'])) {
        } elseif(!empty($_POST['inputEmail'])) {
            include_once 'inc/class.users.inc.php';
            $users = new ClimbCompUsers($db);
            if($users->accountLogin() == TRUE) {
                echo "<meta http-equiv='refresh' content='0;/'>";
                exit;
            } else {
    ?>
                <h2>Login Failed. Try Again.</h2>

                <!-- begin login content forms -->
                <!-- help from bootstrap docs -->
                <div class="container">
                    <form action="login.php" method="post" name="loginForm" id="loginForm">
                        <div class="form-group">
                            <label for="inputEmail">Email address</label>
                            <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword1">Password</label>
                            <input type="password" name="inputPassword1"  class="form-control" id="inputPassword1" placeholder="Password">
                        </div>
                        <input type="submit" class="btn btn-default"></input>
                    </form>
                </div>

            <?php
                    }
                } else {
            ?>
                <!-- begin login content forms -->
                <!-- help from bootstrap docs -->
                <div class="container">
                    <form action="login.php" method="post" name="loginForm" id="loginForm">
                        <div class="form-group">
                            <label for="inputEmail">Email address</label>
                            <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword1">Password</label>
                            <input type="password" name="inputPassword1"  class="form-control" id="inputPassword1" placeholder="Password">
                        </div>
                        <input type="submit" name="login" id="login" value="Login" class="btn btn-default"></input>
                    </form>
                </div>
            <?php
                }
            ?>

</body>

</html>
