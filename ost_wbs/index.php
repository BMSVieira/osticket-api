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
        // Parameters
        $key = array("apikey" => $request['apikey']);
        $classe = ucfirst($request['query']);
        $method = $request['condition'];

        $sort = (isset($request['sort'])) ? $request['sort']:'none';

        $parameters = (isset($request['parameters'])) ? explode(",", $request['parameters']):'none';
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
