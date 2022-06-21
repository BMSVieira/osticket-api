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

        public function add($parameters)
        {

            // Check Permission
            Helper::checkPermission();

            // Check Request method
            $validRequests = array("POST", "PUT");
            Helper::validRequest($validRequests);

            // Expected parameters
            $expectedParameters = array("name", "email", "phone", "org_id", "default_email_id", "status");

            // Check if all paremeters are correct
            Helper::checkRequest($parameters, $expectedParameters);

                // Prepare query

                if($this->checkExists('address', $parameters["parameters"]['email']) > 0) { throw new Exception("This email is already being used by a user."); }

                // table - 'user'
                $user = 'insert into '.TABLE_PREFIX.'user (';
                $user .= 'org_id,';
                $user .= 'default_email_id,';
                $user .= 'status,';
                $user .= 'name,';
                $user .= 'created,';
                $user .= 'updated) VALUES ('; 
                $user .= ''.$parameters["parameters"]["org_id"].',';
                $user .= ''.$parameters["parameters"]["default_email_id"].',';
                $user .= ''.$parameters["parameters"]["status"].',';
                $user .= '"'.$parameters["parameters"]["name"].'",';                
                $user .= 'now(),';    
                $user .= 'now())';    

                // Send query to be executed
                $this->execQuery($user); 

                // Get inserted user ID
                $last_user_id = Helper::get_last_id("user", "id");
              
                // table - 'user__cdata'
                $user__cdata = 'insert into '.TABLE_PREFIX.'user__cdata (';
                $user__cdata .= 'user_id,';
                $user__cdata .= 'email,';
                $user__cdata .= 'name,';
                $user__cdata .= 'phone) VALUES ('; 
                $user__cdata .= ''.$last_user_id.',';
                $user__cdata .= '"'.$parameters["parameters"]["email"].'",';
                $user__cdata .= '"'.$parameters["parameters"]["name"].'",';
                $user__cdata .= ''.$parameters["parameters"]["phone"].')';    

                // Send query to be executed
                $this->execQuery($user__cdata); 

                // table - 'user_email'
                $user_email = 'insert into '.TABLE_PREFIX.'user_email (';
                $user_email .= 'user_id,';
                $user_email .= 'address) VALUES ('; 
                $user_email .= ''.$last_user_id.',';
                $user_email .= '"'.$parameters["parameters"]["email"].'")';    

                // Send query to be executed
                return $this->execQuery($user_email);       

        }

        private function checkExists($field, $value)
        {

            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            // Check if already exists
            $checkExists = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."user_email WHERE ".TABLE_PREFIX."user_email.".$field." = '".$value."'");
            $numRows = $checkExists->num_rows;

            return $numRows;

        }

        private function execQuery($string)
        {
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            // Run query
            $insertRecord = $mysqli->query($string);

            if($insertRecord){
                return "Success! Row 1 affected.";
            } else {
                throw new Exception("Something went wrong.");    
            }
        }        
}
?>