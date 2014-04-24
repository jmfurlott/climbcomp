<?php
    include_once "common/base.php";
    include_once "common/header.php";

    //this page allows a competitor to view a comp and compete
    include_once "inc/class.comps.inc.php";
    $comps = new ClimbCompComps($db);
    
    //show the comp info
    $comps->showComp($_GET['comp_id']);
    if(!isset($_GET['climber_id'])) {


        //make sure to add climber to DB if they are new
        if(isset($_POST['inputFirstName'])) {
            include_once "inc/class.climbers.inc.php";
            $climbers = new ClimbCompClimbers($db);
            $climber_id = $climbers->createClimber();
            header("Location: view.php?comp_id=".$_GET['comp_id']."&climber_id=".$climber_id);
        }
?>
        <div class="container">
        <h4>Please enter your first name to enroll into this competition.</h4>
        <form action="view.php?comp_id=<?php echo $_GET['comp_id']?>" method="POST">
            <div class="form-group">
                <label for="inputFirstName">First name: </label>
                <input type="text" name="inputFirstName" id="inputFirstName" class="form-control">
            </div>
            <input type="submit" class="btn btn-default"></input>
        </form>
        
<?php

        echo '</div>';
        
    } else {

        //if someone has hit submit, then update the results
        if(isset($_POST['routeId'])) {
            echo 'routeId: '.$_POST['routeId'];
            include_once "inc/class.results.inc.php";
            $results = new ClimbCompResults($db);
            $results->createResult();
        }

        //now display the table of the comp
        $comps->listRoutesViewer($_GET['comp_id']);
    }

?>
