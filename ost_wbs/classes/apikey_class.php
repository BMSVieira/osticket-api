<?php
class apiKey
{
    public static function check($key)
    {
        // Connect Database
        $Dbobj = new DBConnection(); 
        $mysqli = $Dbobj->getDBConnect();
        $ObterTickets = $mysqli->query("SELECT * FROM ost_api_key WHERE apiKey = '$key'");
        $PrintTickets = $ObterTickets->fetch_object(); 
        $CountR = $ObterTickets->num_rows;
        
        if(!$CountR)
        {
            throw new Exception("No API Key found.");
        }
        
        return $CountR;  
    } 
}
?>