<?php

######################################################################################################
# OSTicket API Config File
# The purpose of this web service is to help the community and leverage the use of OSTicket.

# Developed by: Bruno Vieira 
######################################################################################################

// Database Credentials
define('DBHOST','localhost');
define('DBNAME','osticket_db');
define('DBUSER','osticket_user');
define('DBPASS','MIest2U#');

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
