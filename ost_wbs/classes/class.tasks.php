<?php
class Tasks
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
                    $ticketId = $parameters['parameters']['ticket_id'];

                    // Query
                    $getTask = $mysqli->query("select 
                    ".TABLE_PREFIX."task.id,
                    ".TABLE_PREFIX."task__cdata.task_id,
                    ".TABLE_PREFIX."task.id,
                    ".TABLE_PREFIX."thread.object_id,
                    ".TABLE_PREFIX."thread.id,
                    ".TABLE_PREFIX."thread_entry.thread_id,
                    ".TABLE_PREFIX."task.created,
                    ".TABLE_PREFIX."task.object_id,
                    ".TABLE_PREFIX."task.object_type,
                    ".TABLE_PREFIX."thread.object_type,
                    ".TABLE_PREFIX."task__cdata.title as title,
                    ".TABLE_PREFIX."thread_entry.body as body
                    FROM ".TABLE_PREFIX."task 
                    LEFT JOIN ".TABLE_PREFIX."task__cdata ON ".TABLE_PREFIX."task.id = ".TABLE_PREFIX."task__cdata.task_id 
                    LEFT JOIN ".TABLE_PREFIX."thread ON ".TABLE_PREFIX."task.id = ".TABLE_PREFIX."thread.object_id
                    LEFT JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."thread.id = ".TABLE_PREFIX."thread_entry.thread_id
                    WHERE ".TABLE_PREFIX."task.created >= '".$startDate."'
                    AND ".TABLE_PREFIX."task.created <= '".$endDate."' 
                    AND ".TABLE_PREFIX."task.object_id = ".$ticketId."
                    AND ".TABLE_PREFIX."task.object_type = 'T'
                    AND ".TABLE_PREFIX."thread.object_type = 'A'");

                break;
                case "byTicket":

                    // Get TicketID
                    $ticketId = $parameters['parameters']['ticket_id'];

                    // Query
                    $getTask = $mysqli->query("select 
                    ".TABLE_PREFIX."task.id,
                    ".TABLE_PREFIX."task__cdata.task_id,
                    ".TABLE_PREFIX."task.id,
                    ".TABLE_PREFIX."thread.object_id,
                    ".TABLE_PREFIX."thread.id,
                    ".TABLE_PREFIX."thread_entry.thread_id,
                    ".TABLE_PREFIX."task.created,
                    ".TABLE_PREFIX."task.object_id,
                    ".TABLE_PREFIX."task.object_type,
                    ".TABLE_PREFIX."thread.object_type,
                    ".TABLE_PREFIX."task__cdata.title as title,
                    ".TABLE_PREFIX."thread_entry.body as body
                    FROM ".TABLE_PREFIX."task 
                    LEFT JOIN ".TABLE_PREFIX."task__cdata ON ".TABLE_PREFIX."task.id = ".TABLE_PREFIX."task__cdata.task_id 
                    LEFT JOIN ".TABLE_PREFIX."thread ON ".TABLE_PREFIX."task.id = ".TABLE_PREFIX."thread.object_id
                    LEFT JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."thread.id = ".TABLE_PREFIX."thread_entry.thread_id
                    WHERE ".TABLE_PREFIX."task.object_id = ".$ticketId."
                    AND ".TABLE_PREFIX."task.object_type = 'T'
                    AND ".TABLE_PREFIX."thread.object_type = 'A'");

                    break;
                default:
                    throw new Exception("Unknown Parameter.");
                break;
            }

            // Array that stores all results
            $result = array();
            $numRows = $getTask->num_rows;
            
            // Fetch data
            while($printTask = $getTask->fetch_object())
            {
                    array_push($result,
                        array(
                            'task_id'=>$printTask->id,
                            'title'=>utf8_encode($printTask->title),
                            'description'=>utf8_encode($printTask->body),
                            'created'=>$printTask->created
                      ));   

            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }
            
            // build return array
            $returnArray = array('total' => $numRows, 'tasks' => $result); 
            
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
            $taskID = $parameters["parameters"]["id"];

            // set query
            $getTask = $mysqli->query("select 

            ".TABLE_PREFIX."task__cdata.task_id,
            ".TABLE_PREFIX."thread.object_id,
            ".TABLE_PREFIX."thread.id,
            ".TABLE_PREFIX."task.id,
            ".TABLE_PREFIX."thread_entry.thread_id,
            ".TABLE_PREFIX."task.created,
            ".TABLE_PREFIX."task.object_id,
            ".TABLE_PREFIX."task.object_type,
            ".TABLE_PREFIX."thread.object_type,
            ".TABLE_PREFIX."task__cdata.title as title,
            ".TABLE_PREFIX."thread_entry.body as body
            FROM ".TABLE_PREFIX."task 
            INNER JOIN ".TABLE_PREFIX."task__cdata ON ".TABLE_PREFIX."task.id = ".TABLE_PREFIX."task__cdata.task_id 
            INNER JOIN ".TABLE_PREFIX."thread ON ".TABLE_PREFIX."task.id = ".TABLE_PREFIX."thread.object_id
            INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."thread.id = ".TABLE_PREFIX."thread_entry.thread_id
            AND ".TABLE_PREFIX."task.id = ".$taskID."
                    AND ".TABLE_PREFIX."task.object_type = 'T'
                    AND ".TABLE_PREFIX."thread.object_type = 'A'");

            // Array that stores all results
            $result = array();
            $numRows = $getTask->num_rows;
            
            // Fetch data
            while($printTask = $getTask->fetch_object())
            {
                    array_push($result,
                        array(
                            'task_id'=>$printTask->id,
                            'title'=>utf8_encode($printTask->title),
                            'description'=>utf8_encode($printTask->body),
                            'created'=>$printTask->created
                      ));     
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }

            // build return array
            $returnArray = array('total' => $numRows, 'tasks' => $result); 
            
            // Return values
            return $returnArray;  
        }

}
?>
