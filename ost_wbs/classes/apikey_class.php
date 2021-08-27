<?php
class apiKey
{
    public static function check($key)
    {
        // Connect Database
        $Dbobj = new DBConnection(); 
        $mysqli = $Dbobj->getDBConnect();
        $GetKey = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."api_key WHERE apiKey = '$key'");
        $PrintTickets = $GetKey->fetch_object(); 
        $CountR = $GetKey->num_rows;
        
        if(!$CountR)
        {
            throw new Exception("No API Key found.");
        }
        
        return $CountR;  
    } 
}
?>