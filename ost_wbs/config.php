<?php
// Turn off all error reporting
error_reporting(0);

// Database Credentials
define('DBHOST','{DBHOST}');
define('DBNAME','{DBNAME}');
define('DBUSER','{DBUSER}');
define('DBPASS','{DBPASS}');

class DBConnection{
    function getDBConnect(){
        
        $mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME) or die("Couldn't connect");
       
        
        if ($mysqli->connect_errno)
        { 
            echo "ERROR: Cannot connect web service to database";
            echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>"; 
            exit();
        } 
         return $mysqli;
    }
}

#######################################################################################################
// API GLOBAL RULES
#######################################################################################################

// Available Ticket Status
define('ATSTATUS', array(0,1,2,3,4,5,6,7));


?>
