<?php
class Department 
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
                    $getDepartment = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."department WHERE ".TABLE_PREFIX."department.created >= '$startDate' and ".TABLE_PREFIX."department.created <= '$endDate'");

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