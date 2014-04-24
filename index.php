<?php
    include_once "common/base.php";
    include_once "common/header.php";

    
    if(isset($_SESSION['logged_in']) && isset($_SESSION['email']) && $_SESSION['logged_in'] == 1) {

        include_once "inc/class.comps.inc.php";
        $comps = new ClimbCompComps($db);
?>
    <!-- what to do when you are logged in at the index  
         - show a table of the current comps
         - create a new comp 
    -->
    <div class="container">
        <h4>Create a new comp</h4>
        <form method="post" name="createCompForm" id="createCompForm" action="edit.php?user_id=<?php echo $_SESSION['user_id']?>">
            
            <div class="form-group">
                <label for="inputCompName">Enter comp name</label>
                <input type="text" name="inputCompName" class="form-control" id="inputCompName">
            </div>
            
            <div class="form-group">
                <label for="inputCompDate">Enter comp date</label>
                <input type="date" name="inputCompDate" class="form-control" id="inputCompDate">
            </div>

            <input type="submit" name="create" id="create" value="Create comp" class="btn btn-warning"></input>
        </form>
   
        <?php echo $comps->getComps(); ?>


    </div>
    




    <!-- landing page for those who are not logged in-->

<?php
    } else {
?>
    <!-- begin jumbotron -->
    <!-- image source:http://cliffhangerclimbing.com/coquitlam/files/2010/12/coquitlam-gym-44.jpg -->
    <div class="bg"></div>
    <div class="jumbotron">
        <div class="container">
            <h1>Welcome to climbcomp!</h1>
            <p>A collaborative tool for editing, sharing, and automatically aggregating results from scorecards for any redpoint climbing competition.</p>
            <p><a href="register.php" class="btn btn-warning btn-lg" role="button">Register</a></p>
        </div>
    </div>
 
    
    <!-- content of the acutal site <-->
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="col-xs-4">
                    <h2>Create scorecards</h2>
                    <p>Using an easy to use online score card editor, update the routes with information including route number, the color(s) of tape, the score, and location.  </p>
                </div>
                <div class="col-xs-8">
                    <img class="img-border" src="img/carousel0.png" height="90%" width="90%">
                </div>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="container">
                <div class="col-xs-7">
                    <img class="img-border" src="img/carousel2.png" height="85%" width="85%">
                </div>
                <div class="col-xs-5">
                    <h2>Share with climbers</h2>
                    <p>Provide the climbers with the automatically generated link on comp day instead of printing score cards to allows climbers to enter their scores using their mobile device.</p>
                </div>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="container">
                <div class="col-xs-4">
                    <h2>Collect score data</h2>
                    <p>After time is called, have the climbers submit their scorecards on their mobile to have the results automatically uploaded and stored. Here the results can be quickly aggregated and displayed. </p>
                </div>
                <div class="col-xs-6">
                    <img class="img-border" src="img/carousel1.png" height="100%" width="100%">
                </div>

            </div>
        </div>
    </div>

<?php
    }
?>



    <!-- Footer at the bootom  -->
    <div class="container">
        <hr>
        &copy; Joseph Furlott
    </div>

    <!-- jQuery -->
    <script src="js/jquery-2.1.0.js"></script>
    <script>
var jumboHeight = $('.jumbotron').outerHeight();
function parallax(){
    var scrolled = $(window).scrollTop();
        $('.bg').css('height', (jumboHeight-scrolled) + 'px');
        }

        $(window).scroll(function(e){
            parallax();
            });
    </script>

</body>

</html>
