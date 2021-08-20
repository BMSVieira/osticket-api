<?php

####################################################################################

# OSTicket Webservice v0.0.1
# The purpose of this web service is to help the community and leverage the use of OSTicket.

# Developed by: Bruno Vieira 

####################################################################################


# DEFINE VARIABLES

# Change this variables to match your DB connections.
# You can find this variables in the following location: includes/ost-config.php

define('DBHOST','localhost');
define('DBNAME','osticket_db');
define('DBUSER','osticket_user');
define('DBPASS','MIest2U#');





$link = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

$query = mysqli_query($link, "SHOW TABLES IN osticket_db");
$numrows = mysqli_num_rows($query);
echo "<b>Amount of tables: ".$numrows." and their names:</b>";
while ($row = mysqli_fetch_array($query)) {
    echo $row[0];
    echo "<br>";
}

?>


<?php

echo "########################################################################## <br>";
$query = mysqli_query($link, "SHOW COLUMNS FROM ost_user;");
$numrows = mysqli_num_rows($query);
echo "<b>Amount of tables: ".$numrows." and their names:</b>";
while ($row = mysqli_fetch_array($query)) {
    echo $row[0];
    echo "<br>";
}

?>

<?php

// MYSQLI --------------------------------------------------------------------------------
echo "########################################################################## <br>";
$mysqli_host = "localhost";
$mysqli_database = "osticket_db";
$mysqli_user = "osticket_user";
$mysqli_password = "MIest2U#";

$mysqli = new mysqli($mysqli_host, $mysqli_user, $mysqli_password, $mysqli_database); 
    
if ($mysqli->connect_errno)
{ 
    echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>"; 
    exit();
} 

$ObterDados = $mysqli->query("SELECT * FROM ost_user");
while($PrintDados = $ObterDados->fetch_object())
{
    echo "<br>";
	echo $PrintDados->org_id;
	echo "<br>";
	echo $PrintDados->default_email_id;
	echo "<br>";
    echo $PrintDados->status;
    echo "<br>";
    echo $PrintDados->name;
    echo "<br>";
    echo $PrintDados->created;
    echo "<br>";
    echo $PrintDados->created;
    echo "<br>";
    echo "###############################";

}


?>

