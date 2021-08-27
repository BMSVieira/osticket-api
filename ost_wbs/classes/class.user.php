<?php
class User 
{
        public function all($parameters)
        {
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            switch ($parameters["sort"]) {
                // Sorte by Date
                case "creationDate":

                    $startDate = Helper::getFormatedDate($parameters["parameters"][0], "start");
                    $endDate = Helper::getFormatedDate($parameters["parameters"][0], "end");

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
           
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();
            $uID = $parameters["parameters"][0];

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