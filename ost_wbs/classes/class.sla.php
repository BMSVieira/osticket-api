<?php
class Sla 
{
        public function all($parameters)
        {
            // Escape Parameters
            $parameters['parameters'] = Helper::escapeParameters($parameters["parameters"]);

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
            // Escape Parameters
            $parameters['parameters'] = Helper::escapeParameters($parameters["parameters"]);

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


        public function add($parameters)
        {

            // Check Permission
            Helper::checkPermission();

            // Check Request method
            $validRequests = array("POST", "PUT");
            Helper::validRequest($validRequests);

            // Expected parameters
            $expectedParameters = array("name", "flags", "grace_period", "schedule_id", "notes");

            // Check if all paremeters are correct
            Helper::checkRequest($parameters, $expectedParameters);

                // Check if row already exists
                if($this->checkExists('name', $parameters["parameters"]['name'], "sla")) { throw new Exception("Item Already exists"); }

                // Prepare query
                $paramOrder = "";
                $valuesOrder = "";

                foreach ($parameters["parameters"] as $key => $value) { 

                    // Parameters order
                    $paramOrder = $paramOrder.",".$key; 
                    // Values order
                    if(is_numeric($value)) { $valuesOrder = $valuesOrder.",".$value."";  } else { $valuesOrder = $valuesOrder.",'".$value."'";}
                }

                // Remove first comma
                $paramOrder = substr($paramOrder, 1);
                $valuesOrder = substr($valuesOrder, 1);

                // final Query
                $addQuery = "INSERT INTO ".TABLE_PREFIX."sla ";
                $addQuery .= "(".$paramOrder.", created, updated)";
                $addQuery .= "VALUES(".$valuesOrder.", now(), now())"; 

                // Send query to be executed
                return $this->execQuery($addQuery);        

        }

        public function delete($parameters)
        {

            // Check Permission
            Helper::checkPermission();

            // Check Request method
            $validRequests = array("DELETE");
            Helper::validRequest($validRequests);

            // Expected parameters
            $expectedParameters = array("id");

            // Check if all paremeters are correct
            Helper::checkRequest($parameters, $expectedParameters);

                // Prepare query
                $paramOrder = "";
                $valuesOrder = "";

                if($this->checkExists('id', $parameters["parameters"]['id'], "sla") == 0) { throw new Exception("Item does not exist."); }

                foreach ($parameters["parameters"] as $key => $value) { 

                    // Parameters order
                    $paramOrder = $paramOrder.",".$key; 
                    // Values order
                    if(is_numeric($value)) { $valuesOrder = $valuesOrder.",".$value."";  } else { $valuesOrder = $valuesOrder.",'".$value."'";}
                }

                // Remove first comma
                $paramOrder = substr($paramOrder, 1);
                $valuesOrder = substr($valuesOrder, 1);

                // final Query
                $addQuery = "DELETE FROM ".TABLE_PREFIX."sla ";
                $addQuery .= "WHERE id= ".$valuesOrder;

                // Send query to be executed
                return $this->execQuery($addQuery);

        }

        private function checkExists($field, $value, $table)
        {
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            // Check if already exists
            $stmt = $mysqli->prepare("SELECT * FROM ".TABLE_PREFIX."".$table." WHERE ".$field." = ?");
            $stmt->bind_param('s', $value);
            $stmt->execute();

            $result = $stmt->get_result();
            $numRows = $result->num_rows;

            return $numRows;
        }

        private function execQuery($string)
        {
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            // Check if already exists
            $insertRecord = $mysqli->query($string);

            if($insertRecord)
            {
                return "Success! Row 1 affected.";
            } else {
                throw new Exception("Something went wrong.");    
            }
        }

}
?>