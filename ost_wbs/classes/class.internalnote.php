<?php

class Internalnote
{
        // id | pid | thread_id | staff_id | user_id | type | flags | poster | editor | editor_type | source | title | body | format | ip_address | extra | recipients | created | updated |
        function compileResults($result)
        {
            return array(
                    'id'=>$result->id,
                    'pid'=>$result->pid,
                    'thread_id'=>$result->thread_id,
                    'staff_id'=>$result->staff_id,
                    'user_id'=>$result->user_id,
                    'type'=>$result->type,
                    'flags'=>$result->flags,
                    'poster'=>$result->poster,
                    'editor'=>$result->editor,
                    'editor_type'=>$result->editor_type,
                    'source'=>$result->source,
                    'title'=>utf8_encode($result->title),
                    'body'=>utf8_encode($result->body),
                    'format'=>$result->format,
                    'ip_address'=>$result->ip_address,
                    'extra'=>$result->extra,
                    'recipients'=>$result->recipients,
                    'created'=>$result->created,
                    'updated'=>$result->updated
            );
        }

        public function getByMid($parameters)
        {
            $parameters['parameters'] = Helper::escapeParameters($parameters["parameters"]);

            // Check Request method
            $validRequests = array("GET");
            Helper::validRequest($validRequests);

            // Connect Database
            $Dbobj = new DBConnection();
            $mysqli = $Dbobj->getDBConnect();
            $MID = $parameters["parameters"]['mid'];



            $getThreadEntry = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."thread_entry WHERE id = (SELECT thread_entry_id FROM ".TABLE_PREFIX."thread_entry_email where mid='".$MID."');");

            // Array that stores all results
            $result = array();
            $numRows = $getThreadEntry->num_rows;

            // Fetch data
            while($PrintTreadEntries = $getThreadEntry->fetch_object()){ array_push($result, self::compileResults($PrintTreadEntries)); }

            // Check if there are some results in the array
            if(!$result){
                throw new Exception("No items found.");
            }

            // build return array
            $returnArray = array('total' => $numRows, 'thread_entries' => $result);

            // Return values
            return $returnArray;
        }

        public function addInternalNote($parameters) {
            try {
                $parameters['parameters'] = Helper::escapeParameters($parameters["parameters"]);

                // Check Permission
                Helper::checkPermission();

                // Check Request method
                $validRequests = array("POST", "PUT");
                Helper::validRequest($validRequests);

                // Expected parameters
                $expectedParameters = array("internal_note_subject", "internal_note",  "staff_id", "user_id","thread_id", "poster");

                // Check if all paremeters are correct
                Helper::checkRequest($parameters, $expectedParameters);

                // Check if ticket exists
                if($this->checkExists('thread_id', $parameters["parameters"]['thread_id'], "thread_entry") == 0) { throw new Exception("Thread does not exist."); }
                // Check if staff exists
                if($this->checkExists('staff_id', $parameters["parameters"]['staff_id'], "staff") == 0) { throw new Exception("Staff does not exist."); }

                // table - 'thread_entry'
                $thread_entry = 'insert into '.TABLE_PREFIX.'thread_entry (';
                $thread_entry .= 'format,';
                $thread_entry .= 'ip_address,';
                $thread_entry .= 'pid,';
                $thread_entry .= 'thread_id,';
                $thread_entry .= 'staff_id,';
                $thread_entry .= 'user_id,';
                $thread_entry .= 'type,';
                $thread_entry .= 'poster,';
                $thread_entry .= 'flags,';
                $thread_entry .= 'source,';
                $thread_entry .= 'title,';
                $thread_entry .= 'body,';
                $thread_entry .= 'created,';
                $thread_entry .= 'updated) VALUES (';
                $thread_entry .= '"html",';
                $thread_entry .= '0,';
                $thread_entry .= '0,';
                $thread_entry .= ''.$parameters["parameters"]["thread_id"].',';
                $thread_entry .= ''.$parameters["parameters"]["staff_id"].',';
                $thread_entry .= ''.$parameters["parameters"]["user_id"].',';
                $thread_entry .= '"N",';
                $thread_entry .= '"'.$parameters["parameters"]["poster"].'",';
                $thread_entry .= '64,';
                $thread_entry .= '"API",';
                $thread_entry .= '"'.utf8_decode($parameters["parameters"]["internal_note_subject"]).'",';
                $thread_entry .= '"<p>'.utf8_decode($parameters["parameters"]["internal_note"]).'</p>",';
                $thread_entry .= 'now(),';
                $thread_entry .= 'now())';

                // Send query to be executed
                $internal_note = $this->execQuery($thread_entry);

                return $internal_note;
            } catch (Exception $e)
            {
                 return json_encode(array('status' => 'Error', 'data' => $e->getMessage()));
            }
        }

        private function execQuery($string)
        {
            // Connect Database
            $Dbobj = new DBConnection();
            $mysqli = $Dbobj->getDBConnect();

            // Run query
            $insertRecord = $mysqli->query($string);

            if($insertRecord){

                // Get inserted ticket ID
                $last_ticket_id = Helper::get_last_id("thread_entry", "id");
                return $last_ticket_id;

            } else {
                throw new Exception("Something went wrong.");
            }
        }

        private function checkExists($field, $value, $table)
        {
            // Connect Database
            $Dbobj = new DBConnection();
            $mysqli = $Dbobj->getDBConnect();

            // Check if already exists
            $stmt = $mysqli->prepare("SELECT * FROM ".TABLE_PREFIX."".$table." WHERE ".$field." = ?");
            $stmt->bind_param('s', $value);
            $stmt->execute();

            $result = $stmt->get_result();
            $numRows = $result->num_rows;

            return $numRows;
        }

}
?>