<?php
    include_once "common/base.php";
    include_once "common/header.php";

    if(isset($_GET['user_id']) && $_GET['user_id'] == $_SESSION['user_id'] && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1  && isset($_GET['comp_id'])) {
        //TODO:make work for now but need to insure that no hackers can get on
        //if we are it means that the user is logged and trying to edit a comp that has already been created at some point
        include_once "inc/class.comps.inc.php";
        $comps = new ClimbCompComps($db);
        
?>
    <div id="showComp">
<?php
        $comps->showComp($_GET['comp_id']);
?>
    </div>
    <div id="editComp">
    
<?php
        $comps->editComp($_GET['comp_id']);
?>
    </div>
    <div class="container">
        <blockquote>This page is viewable at: <a href="http://192.168.56.102/view.php?comp_id=<?php echo $_GET['comp_id']; ?>">http://192.168.56.102/view.php?comp_id=<?php echo $_GET['comp_id']; ?></a></blockquote>
    </div>

<?php
        $comps->editRoutes($_GET['comp_id']);

        //start showing results
?>
        <div class="container">
            <hr>
            <h4>Current Results</h4>
            <?php
                //if there are results for this comp put them here
                include_once "inc/class.results.inc.php";
                $results = new ClimbCompResults($db);
                $results->listResults($_GET['comp_id']);

            ?>
        
        </div>

<?php

    } else if(isset($_GET['user_id']) && $_GET['user_id'] == $_SESSION['user_id'] && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        
        //we are logged in and ready to create a new comp
        include_once "inc/class.comps.inc.php";
        $comps = new ClimbCompComps($db);
        $comp_id = $comps->createComp();
        header('Location: edit.php?user_id='.$_GET['user_id'].'&comp_id='.$comp_id);

         



    } else {
        //user is not logged in or wrong user_id in bar. some security necessary

        echo '<div class="container">';
        echo '<h4>User is not logged in.</h4>';
        echo '</div>';

    }
?>

<script src="js/jquery-2.1.0.min.js"></script>
<script>
     window.reload = function() {
        $('#editComp').hide();

        $('#showComp').click(function(event) {
            $(this).hide();
            $('#editComp').show();
        });
    };
    window.onload = function() {
        $('#editComp').hide();

        $('#showComp').click(function(event) {
            $(this).hide();
            $('#editComp').show();
        });
    };

   // $('#editComp').hide();
   // $('#showComp').click(function() {
   //     $(this).hide();
   //     $('#editComp').show();
   // }
</script>



</body>

</html>
