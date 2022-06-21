<?php

# DB Connection
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

?>