<?php

class Faq 
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
        $getCategories = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."faq_category WHERE ispublic = 1");

        // Array that stores all results
        $result = array();
        $numRows = $getCategories->num_rows;

        // Fetch data
        while($PrintCategories = $getCategories->fetch_object())
        {

                array_push($result,
                    array(
                        'id'=>$PrintCategories->category_id,
                        'parent'=>$PrintCategories->category_pid,
                        'ispublic'=>$PrintCategories->ispublic,
                        'name'=>utf8_encode($PrintCategories->name),
                        'description'=>$PrintCategories->description,
                        'notes'=>$PrintCategories->notes,
                        'created'=>$PrintCategories->created,
                        'updated'=>$PrintCategories->updated
                  ));   

        }
        
        foreach ($result as $key=>$category) {
            
            if ($result[$key]['faqs'] = $this->specific(['parameters'=>["id"=>$category['id']]],TRUE) )
            {
                
            } else {
                $result[$key]['faqs'] = NULL;
                
            }

            $i = 0;
            if ($category['parent']) {
                
                $parentArrayID = $this->getCategoryID($category['parent'],$result);
                $result[$parentArrayID]['children'][] = $result[$key];
                $result[$parentArrayID]['children']['count'] = ++$i;
                --$numRows;
                unset($result[$key]);
                
            } else {

                $result[$key]['children']['count'] = 0;
                
            }

        }

        // Check if there are some results in the array
        if(!$result){
            throw new Exception("No items found.");
        }

        // build return array
        $returnArray = array('total' => $numRows, 'categories' => $result); 

        // Return values
        return $returnArray;  
    }

    public function specific($parameters,$exception = FALSE)
    {
        // Escape Parameters
        $parameters['parameters'] = Helper::escapeParameters($parameters["parameters"]);

        // Check Request method
        $validRequests = array("GET");
        Helper::validRequest($validRequests);

        // Connect Database
        $Dbobj = new DBConnection(); 
        $mysqli = $Dbobj->getDBConnect();
        $cID = $parameters["parameters"]["id"];

        // Query
        $getFaq = $mysqli->query("SELECT * FROM ".TABLE_PREFIX."faq WHERE category_id = " . $cID . " AND ispublished = 1");

        // Array that stores all results
        $result = array();
        $numRows = $getFaq->num_rows;

        // Fetch data
        while($PrintFaq = $getFaq->fetch_object())
        {
                array_push($result,
                    array(
                        'id'=>$PrintFaq->faq_id,
                        'category'=>$PrintFaq->category_id,
                        'ispublished'=>$PrintFaq->ispublished,
                        'question'=>utf8_encode($PrintFaq->question),
                        'answer'=>$PrintFaq->answer,
                        'keywords'=>$PrintFaq->keywords,
                        'notes'=>$PrintFaq->notes,
                        'created'=>$PrintFaq->created,
                        'updated'=>$PrintFaq->updated
                  ));   

        }

        // Check if there are some results in the array
        if(!$result && !$exception) {
            throw new Exception("No items found.");
        }

        // build return array
        $returnArray = array('total' => $numRows, 'faq' => $result); 

        // Return values
        return $returnArray;  
    }

    private function getCategoryID($id, $results)
    {
        if (!is_array($results)){

            throw new Exception("Invalid type.");

        }
        foreach ($results as $key=>$result)
        {
            if($result['id'] == $id) {
                
                return $key;

            }
        }

        throw new Exception("Error creating category structure.");
    }

}

?>
