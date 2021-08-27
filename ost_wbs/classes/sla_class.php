<?php
class Sla 
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
            $uID = $parameters["parameters"][0];

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