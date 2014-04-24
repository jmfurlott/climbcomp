<?php

    class ClimbCompRoutes {
        
        //the db object
        private $_db;
    
        public function __construct($db=NULL) {
            if(is_object($db)) {
                $this->_db = $db;
            } else {
                $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
                $this->_db = new PDO($dsn, DB_USER, DB_PASS);
            }

        }
        
        //create a route based on the comp_id
        public function createRoute($comp_id) {
            //TODO:first check that the comp_id exists?
            
            $route_num = trim($_POST['inputRouteNum']);
            $color = trim($_POST['inputColor']);
            $points = trim($_POST['inputPoints']);
            $location = trim($_POST['inputLocation']);

            //echo $route_num;
            //echo $color;
            //echo $points;
            //echo $location;

            $sql = "INSERT INTO routes(comp_id, route_num, color, points, location)
                    VALUES(:_comp_id, :_route_num, :_color, :_points, :_location)";
            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":_comp_id", $comp_id, PDO::PARAM_STR);
                $stmt->bindParam(":_route_num", $route_num, PDO::PARAM_STR);
                $stmt->bindParam(":_color", $color, PDO::PARAM_STR);
                $stmt->bindParam(":_points", $points, PDO::PARAM_STR);
                $stmt->bindParam(":_location", $location, PDO::PARAM_STR);

                $stmt->execute();
                $stmt->closeCursor();

                $route_id = $this->_db->lastInsertId();
                
                return $route_id;
            } else {
                echo 'failed';
                return NULL;
            }
            

            //return the route_id?
        }

        
        //list the routes based on the comp_id
        public function listRoutes($comp_id) {
            //retrieve the routes
            $sql = "SELECT *
                    FROM routes
                    WHERE comp_id=:comp_id";

            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":comp_id", $comp_id, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();

                if(count($rows) > 0) {
                    //output as tr's
                    foreach($rows as $row) {
                        echo '<tr>';
                        echo '<td>'.$row['route_num'].'</td>';
                        echo '<td>'.$row['color'].'</td>';
                        echo '<td>'.$row['points'].'</td>';
                        echo '<td>'.$row['location'].'</td>';
                        echo '</tr>';
                    }
                } else {
                    
                }

            }
        }


    }
?>
