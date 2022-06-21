<?php
class apiKey
{

    var $farray;

    function __construct() {
        $this->key = false;
        $this->cancreate = false;
        $this->isactive = false;
        $this->countR = false;
    }

    function OAuth($key)
    {

        if($key) $this->key = $key;
        if(strlen($key) != 32) { throw new Exception("Incorrect API Format"); }

        // Connect Database
        $Dbobj = new DBConnection(); 
        $mysqli = $Dbobj->getDBConnect();

        // Check API Key
        $stmt = $mysqli->prepare("SELECT * FROM ".TABLE_PREFIX."api_key WHERE apiKey = ?");
        $stmt->bind_param('s', $key);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $this->farray = $row; 
        $this->countR = $result->num_rows;

        // If exists
        if(!$this->countR)
            throw new Exception("No API Key found.");
        // Check IPAddress
        if(!$row["isactive"] || APIKEY_RESTRICT && $row["ipaddr"] != $_SERVER['REMOTE_ADDR'])
            throw new Exception("API key not found/active or source IP not authorized");
         
        define('CANCREATE', $this->farray["can_create_tickets"]); // Can create
        define('CANEXECUTE', $this->farray["can_exec_cron"]);   // Can execute

    } 

    function cancreate()
    {
        return $this->farray["can_create_tickets"];
    }

    function isactive()
    {
        return $this->farray["isactive"];
    }

    function ippaddr()
    {
        return $this->farray["ippaddr"];
    }

}

// Init API Key verification
$apiAuth = new apiKey;
$apiAuth->OAuth($key["apikey"]);

?>