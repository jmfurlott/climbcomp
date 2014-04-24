       <?php
        //not sure if this where the PHP should exactly go
        include_once "common/base.php";
        include_once "common/header.php";
        $pageTitle = "Register";
        if(!empty($_POST['inputEmail'])) {
            include_once "inc/class.users.inc.php";
            $users = new ClimbCompUsers($db);
            echo $users->createAccount();
        } else {

    ?>



    <!-- begin login content forms -->
    <!-- help from bootstrap docs -->
    <div class="container">
        <form method="post" action="register.php" id="registerForm">
            <div class="form-group">
                <label for="inputFirstName">First name</label>
                <input type="text" name="inputFirstName" class="form-control" id="inputFirstName" placeholder="Enter first name">
            </div>
            <div class="form-group">
                <label for="inputLastName">Last name</label>
                <input type="text" name="inputLastName" class="form-control" id="inputLastName" placeholder="Enter last name">
            </div>
            <div class="form-group">
                <label for="inputLocation">Gym Location</label>
                <input type="text" name="inputLocation" class="form-control" id="inputLocation" placeholder="Enter location">
            </div>
            <div class="form-group">
                <label for="inputEmail">Email address</label>
                <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="inputPassword1">Password</label>
                <input type="password" name="inputPassword1" class="form-control" id="inputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="inputPassword2">Password (again)</label>
                <input type="password" name="inputPassword2" class="form-control" id="inputPassword2" placeholder="Password">
            </div>
            <input type="submit" class="btn btn-default"></input>
        </form>
    </div>
    <?php 
        }
    //    include_once 'common/close.php';
    ?>

</body>

</html>
