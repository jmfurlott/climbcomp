<?php
    
    class ClimbCompComps {
        
        //the db object
        private $_db;   
          
        //constructor  
        public function __construct($db=NULL) {
            if(is_object($db)) {
                $this->_db = $db; 
            } else {
                $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
                $this->_db = new PDO($dsn, DB_USER, DB_PASS);
            }
        }
        

        //create an actual comp
        public function createComp() {
            //going to be a get
            $user_id = trim($_GET['user_id']);
            $comp_name = trim($_POST['inputCompName']);
            $comp_date = trim($_POST['inputCompDate']);
            
            //how can we check if the user is logged in?

            //check that there is a user_id
            $sql = "SELECT COUNT(user_id) as theCount
                    FROM users
                    WHERE user_id=:_user_id";
            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":_user_id", $user_id, PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();

                if($row['theCount'] == 0) {
                    //means there does not exist this user
                    return "<h2>User does not exist</h2>";
                }

                //check logged in here maybe
            }

            //made it through verification so create new route
            $sql = "INSERT INTO comps(user_id, comp_name, comp_date)
                    VALUES(:_user_id, :comp_name, :comp_date)";
            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":_user_id", $user_id, PDO::PARAM_STR);
                $stmt->bindParam(":comp_name", $comp_name, PDO::PARAM_STR);
                $stmt->bindParam(":comp_date", $comp_date, PDO::PARAM_STR);


                $stmt->execute();
                $stmt->closeCursor();

                $comp_id = $this->_db->lastInsertId();
                $url = dechex($user_id);
                //insert re-direct here I think
                return $comp_id;

            } else {
                return NULL;
            }

        }
        public function updateComp($comp_id, $comp_name, $comp_date) {
             //update function
             $sql = "UPDATE comps
                     SET comp_name=:comp_name, comp_date=:comp_date
                     WHERE comp_id=:comp_id";
        
             if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":comp_name", $comp_name, PDO::PARAM_STR);
                $stmt->bindParam(":comp_date", $comp_date, PDO::PARAM_STR);
                $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);

                $stmt->execute();

                return TRUE;
             } else {
                return FALSE;
             }
        }
        
        public function getComps() {
            //this will return a list of current comps that that id has.
            //to be viewed only on a logged in index.php
            
            //first check if logged in
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1 && isset($_SESSION['email'])) {
                $user_id = $_SESSION['user_id'];
                
                //check to see if can return anything
                $sql = "SELECT COUNT(comp_name) as theCount
                        FROM comps
                        WHERE user_id=:_user_id";
                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bindParam(":_user_id", $user_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    if($row['theCount'] == 0) {
                        //return meaning that there is nothing display
                        return;
                    }

                }
               
                //if we have made it this far, then there are comps to display
                echo "<h3>Current list of comps</h3>";

                $sql = "SELECT comp_name, comp_date, comp_id
                        FROM comps
                        WHERE user_id=:_user_id";
                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bindParam(":_user_id", $user_id, PDO::PARAM_STR);
                    $stmt->execute();
                   
                    //TODO: make the comps clickable to edit
                    //initiate table
                    echo '<table class="table table-bordered table-hover">';
                    echo '<tr><th>Comp Name</th><th>Comp Date</th></tr>';
                    while($row = $stmt->fetch()) {
                        //table format??
                        echo '<tr><td><a href="edit.php?user_id='.$user_id."&comp_id=".$row['comp_id'].'">'.$row['comp_name'].'</a></td><td>'.$row['comp_date'].'</td></tr>';

                    }
                    echo '</table>';
        
                }
    
            }

        }

        public function showComp($comp_id) {
            //print form to edit the comp details (name and time)
            //first, go retrieve the comp data
            $comp_name = '';
            $comp_date = '';
            if(isset($_POST['inputCompDate']) || isset($_POST['inputCompName'])) {
                $comp_name = $_POST['inputCompName'];
                $comp_date = $_POST['inputCompDate'];
                $this->updateComp($comp_id, $_POST['inputCompName'], $_POST['inputCompDate']);

            } else {

                $sql = "SELECT comp_id, comp_name, comp_date
                        FROM comps
                        WHERE comp_id=:comp_id";
                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $comp = $stmt->fetch();
                    $comp_name = $comp['comp_name'];
                    $comp_date = $comp['comp_date'];

                }
            }

            
            
            echo '<div class="container">';
            echo '<div class="row">';
            echo '<div class="col-xs-6">';
            echo '<h3>'.$comp_name.'</h3>';
            echo '</div>';
            echo '<div class="col-xs-6">';
            echo '<h3>'.$comp_date.'</h3>';
            echo '</div></div>';
            echo '<hr></div>';
            


        }

        public function editComp($comp_id) {
            
            //print form to edit the comp details (name and time)
            //first, go retrieve the comp data

            $comp_name = "";
            $comp_date = "";
            if(isset($_POST['inputCompDate']) || isset($_POST['inputCompName'])) {
                $comp_name = $_POST['inputCompName'];
                $comp_date = $_POST['inputCompDate'];
                $this->updateComp($comp_id, $_POST['inputCompName'], $_POST['inputCompDate']);

            } else {

                $sql = "SELECT comp_id, comp_name, comp_date
                        FROM comps
                        WHERE comp_id=:comp_id";
                if($stmt = $this->_db->prepare($sql)) {
                    $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $comp = $stmt->fetch();
                    $comp_name = $comp['comp_name'];
                    $comp_date = $comp['comp_date'];

                }
            }
            echo '<div class="container">';
            echo '<div class="row">';
            echo '<div class="col-xs-5">';
            //form name
            echo '<form method="post" action="edit.php?user_id='.$_SESSION['user_id'].'&comp_id='.$comp_id.'" name="updateComp">';
            echo '<input type="text" name="inputCompName" class="form-control" id="inputCompDate"  placeholder="'.$comp_name.'">';
            echo '</div>';

            //form date
            echo '<div class="col-xs-5">';
            echo '<input type="date" name="inputCompDate" class="form-control" id="inputCompDate" placeholder="'.$comp_date.'">';
            echo '</div>';
            
            //form button
            echo '<div class="col-xs-2">';
            echo '<input type="submit" class="btn btn-default"></input>'; 
            echo '</div>';

            echo '</form>';
            echo '</div>';
            echo '<hr></div>';
        }

        public function editRoutes($comp_id) {
            
            include_once "inc/class.routes.inc.php";
            $routes = new ClimbCompRoutes($this->_db);
            $user_id = $_SESSION['user_id'];
            
            //if the user added a route!
            if(isset($_POST['inputRouteNum'])) {
                $route_id = $routes->createRoute($comp_id);
                //echo '$route_id: '. $route_id;
            }


            //begin creating the table for the routes themselves
            echo '<div class="container"><form method="post" action="edit.php?user_id='.$user_id.'&comp_id='.$comp_id.'">';
            echo '<table class="table table-bordered table-hover">';
            echo '<tr><th>Route Number</th><th>Color</th><th>Points</th><th>Location</th></tr>';
            $routes->listRoutes($comp_id);
            
            //now at the bottom of the table, have a ready to add row
            echo '<tr>';
            echo '<td><input type="text" name="inputRouteNum" class="form-control" id="inputRouteNum"></td>';
            echo '<td><input type="text" name="inputColor" class="form-control" id="inputColor"></td>';
            echo '<td><input type="text" name="inputPoints" class="form-control" id="inputPoints"></td>';
            echo '<td><input type="text" name="inputLocation" class="form-control" id="inputLocation"></td>';
            echo '<td><input type="submit" class="btn btn-default"></td>';
            echo '</tr>';
            echo '</table></form></div>';

        }
    
    
        //for competitor, need to show routes and leave falls, points on the side as forms
        public function listRoutesViewer($comp_id) {            
            //retrieve the routes
            $sql = "SELECT *
                    FROM routes
                    WHERE comp_id=:comp_id";

            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();
                
                echo '<form method="post" action="view.php?comp_id='.$comp_id.'&climber_id='.$_GET['climber_id'].'">';
                echo '<div class="container"><table class="table table-bordered table-hover">';
                echo '<tr><th>Route Number</th><th>Color</th><th>Points</th><th>Location</th><th>Falls</th><th>Signature</th></tr>';
                if(count($rows) > 0) {
                    //output as tr's
                    $climber_id = $_GET['climber_id'];
                    include_once "inc/class.results.inc.php";
                    $results = new ClimbCompResults($this->_db);

                    foreach($rows as $row) {

                        //TODO: check to see if there are results already for this climber.
                        

                        echo '<tr>';
                        echo '<td>'.$row['route_num'].'</td>';
                        echo '<td>'.$row['color'].'</td>';
                        echo '<td>'.$row['points'].'</td>';
                        echo '<td>'.$row['location'].'</td>';
                        
                        $route_id = $row['route_id'];

                        if($results->checkForResult($comp_id, $climber_id, $route_id)) {
                            echo "<td>Already climbed</td>";
                            echo "<td>Already signed</td>";
                        } else {
                        //the forms for the user to fill out
                            echo '<input type="hidden" name="routeId" value="'.$row['route_id'].'"/>';
                            echo '<td><input type="text" name="inputFalls" id="inputFalls" class="form-control" placeholder="0"></td>'; 
                            echo '<td><input type="text" name="inputSignature" id="inputSignature" class="form-control"></td>';
                            echo '<td><input type="submit" name="submit" class="btn btn-default"/></td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    
                }

                echo '</div></table></form>';

            }
        }
    }
?>
