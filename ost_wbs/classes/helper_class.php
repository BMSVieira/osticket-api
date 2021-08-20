<?php
class Helper 
{
		// Check Tickets Status
        ###############################################################
        public function checkTicketStatus($ticketstatus)
        {
            // Map array to check if status is available
            $NAcceptedTicketStatus = array_map(function($ticketstatus){
                return (string) $ticketstatus;
            }, ATSTATUS);

            // then use in array
            if(!in_array($ticketstatus, $NAcceptedTicketStatus)) {
                 throw new Exception("Ticket status not available.");
            } 

            return true;
        }

  		// Get formated date from string
        ###############################################################
        public function getFormatedDate($fullstring, $condition)
        {

			switch ($condition) {
			  case "start":
			        $startDate = substr($fullstring, 0, 10);
           			$result = str_replace("-","/",$startDate);
			    break;
			  case "end":
            		$endDate = substr($fullstring, -10);
            		$result = str_replace("-","/",$endDate);
			    break;
			  default:
			    throw new Exception("Helper: condition date not recognize.");
			} 

			return $result;

        }      

}