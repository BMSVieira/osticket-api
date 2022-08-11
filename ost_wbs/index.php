<?php

####################################################################################

# OSTicket Webservice v0.1.0
# The purpose of this web service is to help the community and leverage the use of OSTicket.

# Developed by: Bruno Vieira 

####################################################################################

// Header type
header('Content-Type: application/json; charset: ut-8');

// Require classes
require_once 'config.php';

// Autoload class files
spl_autoload_register( function ( $class ) {
    require_once 'classes/class.' . lcfirst($class) . '.php';
});

// Main Class
class OSTicketAPI
{
	public static function open($request)
	{
        
        // Header
        $headers = array_change_key_case(getallheaders(), CASE_LOWER);
        $key = array("apikey" => $headers["apikey"]);

        // Body
        $requestBody = json_decode(file_get_contents('php://input'), true);
            
            // Request Data
            $classe = ucfirst($requestBody['query']);
            $method = $requestBody['condition'];

            // Sort & Parameters
            if (isset($requestBody['sort'])) { $sort = $requestBody['sort']; } else { $sort = null; }
            if (isset($requestBody['parameters'])) { $parameters = $requestBody['parameters']; } else { $parameters = null; }

        // Final Parameters
        $fparams = array("sort" => $sort, "parameters" => $parameters);

        try {

            // Check API Key
            require_once 'classes/class.key.php';

                if(class_exists($classe))
                {
                    if(method_exists($classe, $method))
                    {
                        // Start track execution time
                        $time_start = microtime(true); 

                        // Call classe and method
                        $return = call_user_func_array(array(new $classe, $method), array($fparams)); 

                        // End track execution time
                        $time_end = microtime(true);
                        $execution_time = ($time_end - $time_start);

                        if(WRITE_SYSTEMLOG)   
                            helper::syslog($classe, $method, json_encode($return));

                        // Return values
                        return json_encode(array('status' => 'Success', 'time' => $execution_time, 'data' => $return));  

                    } else {
                        return json_encode(array('status' => 'Error', 'message' => 'Condition not found.'));  
                    }

                } else {
                   return json_encode(array('status' => 'Error', 'message' => 'Query not found.'));   
                }
            
            
        } catch (Exception $e)
        {
             return json_encode(array('status' => 'Error', 'data' => $e->getMessage())); 
        }
	}
}

// On request, do this
if(isset($_REQUEST)){ echo OSTicketAPI::open($_REQUEST); }

?>
