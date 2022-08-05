<?php

class Topics 
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

        // Query
        $getTopics = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."help_topic WHERE ispublic = 1 AND topic_pid = 0 ORDER BY sort ASC");

        // Array that stores all results
        $result = array();
        $numRows = $getTopics->num_rows;

        // Fetch data
        while($PrintTopics = $getTopics->fetch_object())
        {

                array_push($result,
                    array(
                        'id'=>$PrintTopics->topic_id,
                        'parent'=>$PrintTopics->topic_pid,
                        'ispublic'=>$PrintTopics->ispublic,
                        'sort'=>$PrintTopics->sort,
                        'topic'=>utf8_encode($PrintTopics->topic),
                        'notes'=>$PrintTopics->notes,
                        'created'=>$PrintTopics->created,
                        'updated'=>$PrintTopics->updated
                  ));   

        }

        // Check if there are some results in the array
        if(!$result){
            throw new Exception("No items found.");
        }

        // build return array
        $returnArray = array('total' => $numRows, 'topics' => $result); 

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

        switch ($parameters["sort"]) {
            // Sorte by Date
            case "id":

                $tID = $parameters["parameters"]["id"];
                // Query
                $getTopics = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."help_topic WHERE ispublic = 1 AND topic_id = " . $tID . " LIMIT 1");

            break;
            case "name":

                $tName = Helper::remove_accents($parameters["parameters"]["name"]);
                // Query
                $getTopics = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."help_topic WHERE ispublic = 1 AND topic LIKE '%" . $tName . "%' LIMIT 1");

                break;
            default:
                throw new Exception("Unknown Parameter.");
            break;
        }

        // Array that stores all results
        $result = array();
        $numRows = $getTopics->num_rows;

        // Fetch data
        while($PrintTopics = $getTopics->fetch_object())
        {

                array_push($result,
                    array(
                        'id'=>$PrintTopics->topic_id,
                        'parent'=>$PrintTopics->topic_pid,
                        'ispublic'=>$PrintTopics->ispublic,
                        'sort'=>$PrintTopics->sort,
                        'topic'=>utf8_encode($PrintTopics->topic),
                        'notes'=>$PrintTopics->notes,
                        'created'=>$PrintTopics->created,
                        'updated'=>$PrintTopics->updated
                  ));   

        }

        // Check if there are some results in the array
        if(!$result){
            throw new Exception("No items found.");
        }

        // build return array
        $returnArray = array('total' => $numRows, 'topic' => $result[0]); 

        // Return values
        return $returnArray;  
    }

}

?>
