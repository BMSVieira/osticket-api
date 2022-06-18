<?php
class Sla 
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
                    $getSla = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."sla WHERE ".TABLE_PREFIX."sla.created >= '$startDate' and ".TABLE_PREFIX."sla.created <= '$endDate'");

                break;
                default:
                    throw new Exception("Unknown Parameter.");
                break;
            }

            // Array that stores all results
            $result = array();
            $numRows = $getSla->num_rows;
            
            // Fetch data
            while($printSla = $getSla->fetch_object())
            {
                    array_push($result,
                        array(
                            'sla_id'=>$printSla->id,
                            'flags'=>$printSla->flags,
                            'grace_period'=>$printSla->grace_period,
                            'name'=>utf8_encode($printSla->name),
                            'notes'=>utf8_encode($printSla->notes),
                            'created'=>$printSla->created
                      ));   
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }
            
            // build return array
            $returnArray = array('total' => $numRows, 'sla' => $result); 
            
            // Return values
            return $returnArray;  
        }

        public function specific($parameters)
        {
           
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();
            $uID = $parameters["parameters"]["id"];

            // set query
            $getSla = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."sla WHERE ".TABLE_PREFIX."sla.id = '$uID'");

            // Array that stores all results
            $result = array();
            $numRows = $getSla->num_rows;
            
            // Fetch data
            while($printSla = $getSla->fetch_object())
            {
                    array_push($result,
                        array(
                            'sla_id'=>$printSla->id,
                            'flags'=>$printSla->flags,
                            'grace_period'=>$printSla->grace_period,
                            'name'=>utf8_encode($printSla->name),
                            'notes'=>utf8_encode($printSla->notes),
                            'created'=>$printSla->created
                      ));     
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }

            // build return array
            $returnArray = array('total' => $numRows, 'sla' => $result); 
            
            // Return values
            return $returnArray;  
        }
}
?>