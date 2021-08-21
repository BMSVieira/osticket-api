<?php
class Ticket 
{
        public function all($parameters)
        {
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            switch ($parameters["sort"]) {
                // Sorte by Date
                case "date":

                    $startDate = Helper::getFormatedDate($parameters["parameters"][0], "start");
                    $endDate = Helper::getFormatedDate($parameters["parameters"][0], "end");

                    // Query
                    $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id WHERE ".TABLE_PREFIX."ticket.created >= '$startDate' and ".TABLE_PREFIX."ticket.created <= '$endDate'");

                break;
                // Sorte by Status
                case "status":

                    // Check if ticket status is available
                    $tStatus = $parameters["parameters"][0];
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
                case "statusbydate":

                    // Get Start&End Date
                    $startDate = Helper::getFormatedDate($parameters["parameters"][0], "start");
                    $endDate = Helper::getFormatedDate($parameters["parameters"][0], "end");

                    // Check valid ticket status
                    $tStatus = $parameters["parameters"][1];
                    Helper::checkTicketStatus($tStatus);

                    // Query
                    $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id WHERE created >= '$startDate' and ".TABLE_PREFIX."ticket.created <= '$endDate' AND ".TABLE_PREFIX."ticket.status_id = '$tStatus'");

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

                    array_push($ownTicket,
                        array(
                            'ticket_id'=>$PrintTickets->ticket_id,
                            'ticket_pid'=>$PrintTickets->ticket_pid,
                            'number'=>$PrintTickets->number,
                            'user_id'=>$PrintTickets->user_id,
                            'user_email_id'=>$PrintTickets->user_email_id,
                            'status_id'=>$PrintTickets->status_id,
                            'dept_id'=>$PrintTickets->dept_id,
                            'sla_id'=>$PrintTickets->sla_id,
                            'topic_id'=>$PrintTickets->topic_id,
                            'staff_id'=>$PrintTickets->staff_id,
                            'team_id'=>$PrintTickets->team_id,
                            'email_id'=>$PrintTickets->email_id,
                            'lock_id'=>$PrintTickets->lock_id,
                            'flags'=>$PrintTickets->flags,
                            'sort'=>$PrintTickets->sort,
                            'ip_address'=>$PrintTickets->ip_address,
                            'source'=>$PrintTickets->source,
                            'source_extra'=>$PrintTickets->source_extra,
                            'isoverdue'=>$PrintTickets->isoverdue,
                            'isanswered'=>$PrintTickets->isanswered,
                            'duedate'=>$PrintTickets->duedate,
                            'est_duedate'=>$PrintTickets->est_duedate,
                            'reopened'=>$PrintTickets->reopened,
                            'closed'=>$PrintTickets->closed,
                            'lastupdate'=>$PrintTickets->lastupdate,
                            'created'=>$PrintTickets->created,
                            'updated'=>$PrintTickets->updated
                      ));   

                     if($countRows == $numRows)
                        array_push($result, $ownTicket);

                    $countRows++;
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }
            
            // Return values
            return $result;  
        }

        public function specific($parameters)
        {
           
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();
            $tID = $parameters["parameters"][0];

            $getTickets = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."ticket INNER JOIN ".TABLE_PREFIX."ticket__cdata ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."ticket__cdata.ticket_id INNER JOIN ".TABLE_PREFIX."thread_entry ON ".TABLE_PREFIX."ticket.ticket_id = ".TABLE_PREFIX."thread_entry.thread_id WHERE ".TABLE_PREFIX."ticket.ticket_id = '$tID' OR ".TABLE_PREFIX."ticket.number = '$tID'");

            // Array that stores all results
            $result = array();
            
            // Fetch data
            while($PrintTickets = $getTickets->fetch_object())
            {
                 array_push($result,
                    array(
                        'ticket_id'=>$PrintTickets->ticket_id,
                        'ticket_pid'=>$PrintTickets->ticket_pid,
                        'number'=>$PrintTickets->number,
                        'user_id'=>$PrintTickets->user_id,
                        'user_email_id'=>$PrintTickets->user_email_id,
                        'status_id'=>$PrintTickets->status_id,
                        'dept_id'=>$PrintTickets->dept_id,
                        'sla_id'=>$PrintTickets->sla_id,
                        'topic_id'=>$PrintTickets->topic_id,
                        'staff_id'=>$PrintTickets->staff_id,
                        'team_id'=>$PrintTickets->team_id,
                        'email_id'=>$PrintTickets->email_id,
                        'lock_id'=>$PrintTickets->lock_id,
                        'flags'=>$PrintTickets->flags,
                        'sort'=>$PrintTickets->sort,
                        'ip_address'=>$PrintTickets->ip_address,
                        'source'=>$PrintTickets->source,
                        'source_extra'=>$PrintTickets->source_extra,
                        'isoverdue'=>$PrintTickets->isoverdue,
                        'isanswered'=>$PrintTickets->isanswered,
                        'duedate'=>$PrintTickets->duedate,
                        'est_duedate'=>$PrintTickets->est_duedate,
                        'reopened'=>$PrintTickets->reopened,
                        'closed'=>$PrintTickets->closed,
                        'lastupdate'=>$PrintTickets->lastupdate,
                        'created'=>$PrintTickets->created,
                        'updated'=>$PrintTickets->updated
                  ));   
            }
        
            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }

            // Return values
            return $result;  
        }
}
?>