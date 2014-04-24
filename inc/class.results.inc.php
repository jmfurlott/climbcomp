<?php
    class ClimbCompResults {
        private $_db;

        public function __construct($db=NULL) {
            if(is_object($db)) {
                $this->_db = $db;
            } else {
                $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
                $this->_db = new PDO($dsn, DB_USER, DB_PASS);
            }
        }

        public function createResult() {
            $climber_id = $_GET['climber_id'];
            $comp_id = $_GET['comp_id'];
            $route_id = $_POST['routeId'];
            $num_falls = $_POST['inputFalls'];
            $signature = $_POST['inputSignature']; //not used yet

            $sql = "INSERT INTO results(comp_id, route_id, climber_id, num_falls)
                    VALUES(:comp_id, :route_id, :climber_id, :num_falls)";

            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);
                $stmt->bindParam(":route_id", $route_id, PDO::PARAM_STR);
                $stmt->bindParam(":climber_id", $climber_id, PDO::PARAM_STR);
                $stmt->bindParam(":num_falls", $num_falls, PDO::PARAM_STR);

                $stmt->execute();

            }

        }
    
        public function checkForResult($comp_id, $climber_id, $route_id) {
            //return true if there exist such as a result and make sure that there is only one result 
            //otherwise return false
            $sql = "SELECT *
                    FROM results
                    WHERE comp_id=:comp_id AND climber_id=:climber_id
                    AND route_id=:route_id";
            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);
                $stmt->bindParam(":climber_id", $climber_id, PDO::PARAM_STR);
                $stmt->bindParam("route_id", $route_id, PDO::PARAM_STR);

                $stmt->execute();
                $rows = $stmt->fetchAll();
                if(sizeof($rows) > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function listResults($comp_id) {
            //currently just printing out each result in a table
            //TODO: summarize each climber_id and add teh results
              
            $sql = "SELECT *
                    FROM results
                    WHERE comp_id=:comp_id";
            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);
                
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if(sizeof($rows) > 0) {
                    echo '<table class="table table-bordered table-hover">';
                    echo '<tr><th>Climber</th><th>Route Number</th><th>Points</th><th>Number of falls</th></tr>';
                    
                    foreach($rows as $row) {
                        //need to perform the sql query for climber name
                        $first_name = "";
                        $sql = "SELECT first_name
                                FROM climbers
                                WHERE climber_id=:climber_id";
                        if($stmt = $this->_db->prepare($sql)) {
                            $stmt->bindParam(":climber_id", $row['climber_id'], PDO::PARAM_STR);
                            $stmt->execute();
                            $climber = $stmt->fetch();
                            $first_name = $climber['first_name'];
                        }
                        
                        //and for route info
                        $sql = "SELECT *
                                FROM routes
                                WHERE route_id=:route_id";
                        $route_num = "";
                        $points = "";
                        if($stmt = $this->_db->prepare($sql)) {
                            $stmt->bindParam(":route_id", $row['route_id'], PDO::PARAM_STR);
                            $stmt->execute();
                            $route = $stmt->fetch();
                            $route_num = $route['route_num'];
                            $points = $route['points'];
                        }

                        //now actually print out the rows
                        echo '<tr>';
                        echo '<td>'.$first_name.'</td>';
                        echo '<td>'.$route_num.'</td>';
                        echo '<td>'.$points.'</td>';
                        echo '<td>'.$row['num_falls'].'</td>';
                        echo '</tr>';

                    }

                }
            }
        }
    }
?>
