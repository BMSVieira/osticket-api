<?php
class Department
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
                    $getDepartment = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."department WHERE ".TABLE_PREFIX."department.created >= '$startDate' and ".TABLE_PREFIX."department.created <= '$endDate'");

                break;
                case "name":
                    $getDepartment = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."department WHERE " . TABLE_PREFIX . "department.pid IS NULL AND " . TABLE_PREFIX . "department.ispublic = 1 ORDER BY " . TABLE_PREFIX . "department.name ASC");
                    break;
                default:
                    throw new Exception("Unknown Parameter.");
                break;
            }

            // Array that stores all results
            $result = array();
            $numRows = $getDepartment->num_rows;
            
            // Fetch data
            while($printDepartment = $getDepartment->fetch_object())
            {
                    array_push($result,
                        array(
                            'department_id'=>$printDepartment->id,
                            'name'=>utf8_encode($printDepartment->name),
                            'created'=>$printDepartment->created
                      ));   

            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }
            
            // build return array
            $returnArray = array('total' => $numRows, 'departments' => $result); 
            
            // Return values
            return $returnArray;  
        }

        public function specific($parameters)
        {
            // Escape Parameters
            $parameters['parameters'] = Helper::escapeParameters($parameters["parameters"]);
           
            // Check Request method
            $validRequests = array("GET");
            Helper::validRequest($validRequests);
            
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();
            $depID = $parameters["parameters"]["id"];

            // set query
            $getDepartment = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."department WHERE ".TABLE_PREFIX."department.id = '$depID'");

            // Array that stores all results
            $result = array();
            $numRows = $getDepartment->num_rows;
            
            // Fetch data
            while($printDepartment = $getDepartment->fetch_object())
            {
                    array_push($result,
                        array(
                            'department_id'=>$printDepartment->id,
                            'name'=>utf8_encode($printDepartment->name),
                            'created'=>$printDepartment->created
                      ));     
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }

            // build return array
            $returnArray = array('total' => $numRows, 'departments' => $result); 
            
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
            $expectedParameters = array("name", "signature", "flags");

            // Check if all paremeters are correct
            Helper::checkRequest($parameters, $expectedParameters);

                // Check if row already exists
                if($this->checkExists('name', $parameters["parameters"]['name'])) { throw new Exception("Item Already exists"); }

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
                $addQuery = "INSERT INTO ".TABLE_PREFIX."department ";
                $addQuery .= "(".$paramOrder.", created, updated)";
                $addQuery .= "VALUES(".$valuesOrder.", now(), now())"; 

                // Send query to be executed
                return $this->execQuery($addQuery);        

        }
        private function checkExists($field, $value)
        {

            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            // Check if already exists
            $checkExists = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."department WHERE ".TABLE_PREFIX."department.".$field." = '".$value."'");
            $numRows = $checkExists->num_rows;

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
