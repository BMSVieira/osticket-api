<?php

class Ticket 
{
        function compileResults($result)
        {
            return array(
                    'ticket_id'=>$result->ticket_id,
                    'ticket_pid'=>$result->ticket_pid,
                    'number'=>$result->number,
                    'user_id'=>$result->user_id,
                    'user_email_id'=>$result->user_email_id,
                    'status_id'=>$result->status_id,
                    'dept_id'=>$result->dept_id,
                    'sla_id'=>$result->sla_id,
                    'topic_id'=>$result->topic_id,
                    'staff_id'=>$result->staff_id,
                    'team_id'=>$result->team_id,
                    'email_id'=>$result->email_id,
                    'lock_id'=>$result->lock_id,
                    'flags'=>$result->flags,
                    'sort'=>$result->sort,
                    'subject'=>utf8_encode($result->subject),
                    'title'=>utf8_encode($result->title),
                    'body'=>utf8_encode($result->body),
                    'ip_address'=>$result->ip_address,
                    'source'=>$result->source,
                    'source_extra'=>$result->source_extra,
                    'isoverdue'=>$result->isoverdue,
                    'isanswered'=>$result->isanswered,
                    'duedate'=>$result->duedate,
                    'est_duedate'=>$result->est_duedate,
                    'reopened'=>$result->reopened,
                    'closed'=>$result->closed,
                    'lastupdate'=>$result->lastupdate,
                    'created'=>$result->created,
                    'updated'=>$result->updated
            );
        }  

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
                    $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id WHERE ".TABLE_PREFIX."ticket.created >= '$startDate' and ".TABLE_PREFIX."ticket.created <= '$endDate'");

                break;
                // Sorte by Status
                case "status":

                    // Check if ticket status is available
                    $tStatus = $parameters["parameters"]["status"];
                    Helper::checkTicketStatus($tStatus);

                    // 0 value does not exist, so it is equal to "all records"
                    switch ($tStatus) {
                        case 0:
                            $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id");
                        break;
                        default:
                            $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id WHERE ".TABLE_PREFIX."ticket.status_id = '$tStatus'");
                        break;
                    }

                break;
                // Sort Status by Date 
                case "statusByDate":

                    // Get Start&End Date
                    $startDate = $parameters['parameters']['start_date'];
                    $endDate = $parameters['parameters']['end_date'];

                    // Check valid ticket status
                    $tStatus = $parameters["parameters"]["status"];
                    Helper::checkTicketStatus($tStatus);

                    // Query
                    $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id WHERE ".TABLE_PREFIX."ticket.created >= '$startDate' and ".TABLE_PREFIX."ticket.created <= '$endDate' AND ".TABLE_PREFIX."ticket.status_id = '$tStatus'");

                break;
                default:
                    throw new Exception("Unknown Parameter.");
                break;
            }

            // Array that stores all results
            $result = array();
            $ownTicket = array();
           
            // get num rows
            $numRows = $getTickets->num_rows;
            $countRows = 1;
            $sameTicket = false;
            
            // Fetch data
            while($PrintTickets = $getTickets->fetch_object())
            {
                    // get whatever ticket id it is
                    if(!$sameTicket) { $sameTicket = $PrintTickets->ticket_id;  }

                    if($PrintTickets->ticket_id != $sameTicket) {  
                        array_push($result, $ownTicket);
                        $sameTicket = $PrintTickets->ticket_id;
                        $ownTicket = array();
                    }

                    // Compile results
                    array_push($ownTicket, self::compileResults($PrintTickets));   

                    if($countRows == $numRows)
                        array_push($result, $ownTicket);

                    $countRows++;
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }
            
            // build return array
            $returnArray = array('total' => $numRows, 'tickets' => $result); 
            
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
            $tID = $parameters["parameters"]['id'];

            $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id WHERE ".TABLE_PREFIX."ticket.ticket_id = '$tID' OR ".TABLE_PREFIX."ticket.number = '$tID'");

            // Array that stores all results
            $result = array();
            $numRows = $getTickets->num_rows;
            
            // Fetch data
            while($PrintTickets = $getTickets->fetch_object()){ array_push($result, self::compileResults($PrintTickets)); }
        	
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }

            // build return array
            $returnArray = array('total' => $numRows, 'tickets' => $result); 
            
            // Return values
            return $returnArray;  
        }

        public function add($parameters)
        {
            // Check Request method
            $validRequests = array("POST", "PUT");
            Helper::validRequest($validRequests);

            return $this->insertRecord($parameters["parameters"]);
        }

        private function insertRecord($values)
        {
        
    
            return $values;
        }
}
?>
