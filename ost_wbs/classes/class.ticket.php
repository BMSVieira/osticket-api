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

            // Check Permission
            Helper::checkPermission();

            // Check Request method
            $validRequests = array("POST", "PUT");
            Helper::validRequest($validRequests);

            // Expected parameters
            $expectedParameters = array("title", "subject", "priority_id", "status_id", "dept_id", "sla_id", "topic_id");

            // Check if all paremeters are correct
            Helper::checkRequest($parameters, $expectedParameters);

                // Prepare query

                $last_ticket_id = Helper::get_last_id("ticket", "ticket_id");
                $ticket_number = $last_ticket_id+1;
                $ticker_number = "API".$ticket_number;

                // table - 'ticket'
                $ticket = 'insert into '.TABLE_PREFIX.'ticket (';
                $ticket .= 'number,';
                $ticket .= 'user_id,';
                $ticket .= 'status_id,';
                $ticket .= 'dept_id,';
                $ticket .= 'sla_id,';
                $ticket .= 'topic_id,';
                $ticket .= 'source,';
                $ticket .= 'isoverdue,';
                $ticket .= 'isanswered,';
                $ticket .= 'lastupdate,';
                $ticket .= 'created,';
                $ticket .= 'updated) VALUES ('; 
                $ticket .= '"'.$ticker_number.'",';   
                $ticket .= '1,';
                $ticket .= ''.$parameters["parameters"]["status_id"].',';
                $ticket .= ''.$parameters["parameters"]["dept_id"].',';
                $ticket .= ''.$parameters["parameters"]["sla_id"].',';
                $ticket .= ''.$parameters["parameters"]["topic_id"].',';
                $ticket .= '"API",';
                $ticket .= '0,';
                $ticket .= '0,';   
                $ticket .= 'now(),';                  
                $ticket .= 'now(),';    
                $ticket .= 'now())';    

                // Send query to be executed
                $this->execQuery($ticket); 

                // Get inserted ticket ID
                $last_ticket_id = Helper::get_last_id("ticket", "ticket_id");

                // table - 'ticket__cdata'
                $ticket__cdata = 'insert into '.TABLE_PREFIX.'ticket__cdata (';
                $ticket__cdata .= 'ticket_id,';
                $ticket__cdata .= 'subject,';
                $ticket__cdata .= 'priority) VALUES (';    
                $ticket__cdata .= ''.$last_ticket_id.',';
                $ticket__cdata .= '"'.$parameters["parameters"]["subject"].'",';
                $ticket__cdata .= ''.$parameters["parameters"]["priority_id"].')';

                // Send query to be executed
                $this->execQuery($ticket__cdata); 

                // table - 'thread'
                $thread = 'insert into '.TABLE_PREFIX.'thread (';
                $thread .= 'object_id,';
                $thread .= 'object_type,';
                $thread .= 'created) VALUES (';    
                $thread .= ''.$last_ticket_id.',';
                $thread .= '"T",';
                $thread .= 'now())';    

                // Send query to be executed
                $this->execQuery($thread); 

                // Get inserted thread ID
                $last_thread_id = Helper::get_last_id("thread", "id");

                // table - 'thread_entry'
                $thread_entry = 'insert into '.TABLE_PREFIX.'thread_entry (';
                $thread_entry .= 'thread_id,';
                $thread_entry .= 'user_id,';                
                $thread_entry .= 'type,';
                $thread_entry .= 'poster,';
                $thread_entry .= 'flags,';
                $thread_entry .= 'source,';
                $thread_entry .= 'title,';
                $thread_entry .= 'body,';
                $thread_entry .= 'created,';
                $thread_entry .= 'updated) VALUES (';    
                $thread_entry .= ''.$last_thread_id.',';
                $thread_entry .= '1,';
                $thread_entry .= '"M",';
                $thread_entry .= '"osTicket Support",';
                $thread_entry .= '65,';
                $thread_entry .= '"API",';
                $thread_entry .= '"'.$parameters["parameters"]["title"].'",';
                $thread_entry .= '"<p>'.$parameters["parameters"]["subject"].'</p>",';
                $thread_entry .= 'now(),';    
                $thread_entry .= 'now())';

                // Send query to be executed
                return $this->execQuery($thread_entry);   

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
