<?php
class Ticket 
{
        public function all($parameters)
        {
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            switch ($parameters["sort"]) {
                case "date":

                    $startDate = Helper::getFormatedDate($parameters["parameters"][0], "start");
                    $endDate = Helper::getFormatedDate($parameters["parameters"][0], "end");

                    // Query
                    $ObterTickets = $mysqli->query("SELECT * FROM ost_ticket WHERE created >= '$startDate' and created < '$endDate'");

                break;
                case "status":

                    // Check if ticket status is available
                    $tStatus = $parameters["parameters"][0];
                    Helper::checkTicketStatus($tStatus);

                    // 0 value does not exist, so it is equal to "all records"
                    switch ($tStatus) {
                        case 0:
                            $ObterTickets = $mysqli->query("SELECT * FROM ost_ticket");
                        break;
                        default:
                            $ObterTickets = $mysqli->query("SELECT * FROM ost_ticket WHERE status_id = '$tStatus'");
                        break;
                    }

                break;
                case "statusbydate":

                    // Get Start&End Date
                    $startDate = Helper::getFormatedDate($parameters["parameters"][0], "start");
                    $endDate = Helper::getFormatedDate($parameters["parameters"][0], "end");

                    // Check valid ticket status
                    $tStatus = $parameters["parameters"][1];
                    Helper::checkTicketStatus($tStatus);

                    // Query
                    $ObterTickets = $mysqli->query("SELECT * FROM ost_ticket WHERE created >= '$startDate' and created < '$endDate' AND status_id = '$tStatus'");

                break;
                default:
                    throw new Exception("Unknown Parameter.");
                break;
            }

            // Array that stores all results
            $result = array();
            
            // Fetch data
            while($PrintTickets = $ObterTickets->fetch_object())
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

        public function specific($parameters)
        {
           
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();
            $tID = $parameters["parameters"][0];

            $ObterTickets = $mysqli->query("SELECT * FROM ost_ticket WHERE ticket_id = '$tID' OR number = '$tID'");

            // Array that stores all results
            $result = array();
            
            // Fetch data
            while($PrintTickets = $ObterTickets->fetch_object())
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