<?php

    class ClimbCompUsers {
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
    
        public function createAccount() {
            $first_name = trim($_POST['inputFirstName']);
            $last_name = trim($_POST['inputLastName']);
            $gym_location = trim($_POST['inputLocation']);
            $email = trim($_POST['inputEmail']);
            $password1 = $_POST['inputPassword1'];
            $password2 = $_POST['inputPassword2'];
            
            $v = sha1(time());

            $sql = "SELECT COUNT(email) as theCount
                    FROM users
                    WHERE email=:_email";
            
            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":_email", $email, PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                if($row['theCount'] != 0) {
                    return "<h2>Error</h2>" .
                           "<p>Sorry, that email is already being used. " .
                           "Please try again.";
                }
                if(!$this->sendVerificationEmail($email, $v)) {
                    return "<h2>Error<h2>" .
                           "<p> There was an error sending your verification email.";
                }
                $stmt->closeCursor();
            }
            
            //if we have made it, means we are done validating. Ready to insert to db
            $sql = "INSERT INTO users(first_name, last_name, gym_location, email, ver_code)
                    VALUES(:first_name, :last_name, :gym_location, :email, :ver_code)";
            if($stmt = $this->_db->prepare($sql)) {
                $stmt->bindParam(":first_name", $first_name, PDO::PARAM_STR);
                $stmt->bindParam(":last_name", $last_name, PDO::PARAM_STR);
                $stmt->bindParam(":gym_location", $gym_location, PDO::PARAM_STR);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":ver_code", $v, PDO::PARAM_STR);
                
                $stmt->execute();
                $stmt->closeCursor();

                $user_id = $this->_db->lastInsertId();
                $url = dechex($user_id);
                
                return "<h2> Success!</h2>" .
                       "<p>Your account was successfully created at email address: ".
                       "<strong>$email</strong>.";
                
            } else {
                return "<h2>Error</h2>" .
                       "<p>Could not insert information into database.";
            }
            
        }

        private function sendVerificationEmail($email, $ver) {
            //TODO
            return 1;
        }

        
        //LOGGING IN
        //TODO: only checking for same email. no authentication yet
        public function accountLogin() {
        
           $sql = "SELECT email,user_id,first_name
                   FROM users
                   WHERE email=:_email
                   LIMIT 1";//"AND password=MD5(:pass)


            try {
                $stmt = $this->_db->prepare($sql);
                $stmt->bindParam(':_email', $_POST['inputEmail'], PDO::PARAM_STR);
                //$stmt->bindParam(':pass', $_POST['inputPassword1'], PDO::PARAM_STR);

                $stmt->execute();
                if($stmt->rowCount() == 1) {
                    $_SESSION['email'] = htmlentities($_POST['inputEmail'], ENT_QUOTES);
                    $_SESSION['logged_in'] = 1;
                    $row = $stmt->fetch();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['first_name'] = $row['first_name'];
                    return TRUE;
                } else {
                    return FALSE;
                }
            } catch(PDOException $e) {
                return FALSE;
            }
        }

    }

?>
