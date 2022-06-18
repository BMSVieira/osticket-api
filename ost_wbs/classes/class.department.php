<?php
class Department
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
           
            // Check Request method
            $validRequests = array("GET");
            Helper::validRequest($validRequests);
            
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();
            $depID = $parameters["parameters"][0];

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
}
?>
