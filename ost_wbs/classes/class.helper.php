<?php
class Helper 
{
    // Check Tickets Status
    static function checkTicketStatus($ticketstatus)
    {
        // Map array to check if status is available
        $NAcceptedTicketStatus = array_map(function($ticketstatus){
            return (string) $ticketstatus;
        }, ATSTATUS);

        // then use in array
        if(!in_array($ticketstatus, $NAcceptedTicketStatus)) {
             throw new Exception("Ticket status not available.");
        } 

        return true;
    }

    // Get formated date from string
    static function getFormatedDate($fullstring, $condition)
    {

    	switch ($condition) {
    	  case "start":
    	        $startDate = substr($fullstring, 0, 10);
       			$result = str_replace("-","/",$startDate);
    	    break;
    	  case "end":
        		$endDate = substr($fullstring, -10);
        		$result = str_replace("-","/",$endDate);
    	    break;
    	  default:
    	    throw new Exception("Helper: condition date not recognize.");
    	} 

    	return $result;
    } 

    // Check if request method is valid
    static function validRequest($method){
        if(!in_array($_SERVER['REQUEST_METHOD'], $method)){
            throw new Exception($_SERVER['REQUEST_METHOD']." is not a valid request method");
        }     
    } 

    // Check permissions 
    static function checkPermission(){
        if(CANCREATE == 0){ throw new Exception("Error! Your API Key is READ ONLY, it is no allowed to make any action.");}  
    } 

    // Get last ID
    static function get_last_id($table, $field)
    {
        // Connect Database
        $Dbobj = new DBConnection(); 
        $mysqli = $Dbobj->getDBConnect();

        // Get last inserted ID
        $getLastId = $mysqli->query("SELECT ".$field." FROM ".TABLE_PREFIX."".$table." ORDER BY ".$field." DESC LIMIT 1");
        $printLastId = $getLastId->fetch_object();

        return $printLastId->$field;
    }  

    /* Escape parameters */
    static function escapeParameters($parameters)
    {
        // Connect Database
        $Dbobj = new DBConnection(); 
        $mysqli = $Dbobj->getDBConnect();

        foreach($parameters as $key=>$value) {
            $parameters[$key] = mysqli_real_escape_string($mysqli, $parameters[$key]); 
        }

        return $parameters;
    }

    // Check parameters
    static function checkRequest($parameters, $expectedParameters)
    {

        // Error array 
        $errors = array();

        // Check if parameters is an array
        if(gettype($parameters["parameters"]) == 'array'){

            // Check for empty fields
            foreach ($expectedParameters as $key => $value) {
                if(empty($parameters["parameters"][$value])) {
                    array_push($errors,"Empty or Incorrect fields were given.");
                }
            }

            // Check for unkown or unexpected fields
            foreach ($parameters["parameters"] as $key => $value) {
                if (!in_array($key, $expectedParameters)) {
                    array_push($errors,"Unexpectec fields given.");
                }
            }

            // If no errors, continue
            if(count($errors) > 0){
                throw new Exception("Empty or Incorrect fields were given, read documentation for more info."); 
            } 

        } else {
            throw new Exception("Parameters must be an array.");    
        }

    }  
}