<?php
class User 
{
        public function all($parameters)
        {
            // Check Request method
            $validRequests = array("GET");
            Helper::validRequest($validRequests);

            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            switch ($parameters["sort"]) {
                // Sorte by Date
                case "creationDate":

                    // Get Start&End Date
                    $startDate = $parameters['parameters']['start_date'];
                    $endDate = $parameters['parameters']['end_date'];

                    // Query
                    $getUser = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."user WHERE ".TABLE_PREFIX."user.created >= '$startDate' and ".TABLE_PREFIX."user.created <= '$endDate'");

                break;
                default:
                    throw new Exception("Unknown Parameter.");
                break;
            }

            // Array that stores all results
            $result = array();
            $numRows = $getUser->num_rows;
            
            // Fetch data
            while($PrintUsers = $getUser->fetch_object())
            {
                    array_push($result,
                        array(
                            'user_id'=>$PrintUsers->id,
                            'name'=>utf8_encode($PrintUsers->name),
                            'created'=>$PrintUsers->created
                      ));   

            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }
            
            // build return array
            $returnArray = array('total' => $numRows, 'users' => $result); 
            
            // Return values
            return $returnArray;  
        }

        public function specific($parameters)
        {
            // Check Request method
            $validRequests = array("GET");
            Helper::validRequest($validRequests);

            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();
            $uID = $parameters["parameters"]["id"];

            // set query
            $getUser = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."user WHERE ".TABLE_PREFIX."user.id = '$uID'");

            // Array that stores all results
            $result = array();
            $numRows = $getUser->num_rows;
            
            // Fetch data
            while($PrintUsers = $getUser->fetch_object())
            {
                    array_push($result,
                        array(
                            'user_id'=>$PrintUsers->id,
                            'name'=>utf8_encode($PrintUsers->name),
                            'created'=>$PrintUsers->created
                      ));     
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }

            // build return array
            $returnArray = array('total' => $numRows, 'users' => $result); 
            
            // Return values
            return $returnArray;  
        }
}
?>