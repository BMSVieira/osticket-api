<?php

# Turn off all error reporting
error_reporting();

# Database Credentials
define('DBTYPE','');
define('DBHOST','');
define('DBNAME','');
define('DBUSER','');
define('DBPASS','');

# Table prefix
define('TABLE_PREFIX','ost_');

# Global Rules
define('ATSTATUS', array(0,1,2,3,4,5,6,7));
define('APIKEY_RESTRICT', false); // Check for IP authorization

?>
