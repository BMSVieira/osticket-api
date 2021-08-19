<?php

class Ticket 
{
        public function all()
        {
            // Connect Database
            $Dbobj = new DBConnection(); 
            $mysqli = $Dbobj->getDBConnect();

            $ObterTickets = $mysqli->query("SELECT * FROM ost_ticket");
           
            $result = array();
            
            while($PrintTickets = $ObterTickets->fetch_object())
            {
                 array_push($result,
                    array(
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
        
            if(!$result)
            {
                throw new Exception("No items found.");
            }
            
            return $result;
            
        }
    
        public function close()
        {
            // Retrive all Closed tickets
        }
    
        public function open()
        {
            // Retrieve all open tickets
        }
    
        public function specific($parameters)
        {
            // Retrives a specific item
        }
}
?>