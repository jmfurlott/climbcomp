<?php

    class ClimbCompClimbers {
        //really simple class that keeps track of climbers competing
        private $_db;

        public function __construct($db=NULL) {
            if(is_object($db)) {
                $this->_db = $db;
            } else {
                $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
                $this->_db = new PDO($dsn, DB_USER, DB_PASS);
            }
        }

        public function createClimber() {
            //need to reutn the climber_id!
            $first_name = trim($_POST['inputFirstName']);

            $sql = "INSERT INTO climbers(first_name) 
                    VALUES(:first_name)";

            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":first_name", $first_name, PDO::PARAM_STR);

                $stmt->execute();
                $stmt->closeCursor();

                return $this->_db->lastInsertId();
            } else {
                return NULL;
            }   
        }
    }
?>
