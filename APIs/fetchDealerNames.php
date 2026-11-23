<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

//PHP library and PHP global settings files to include
require __DIR__.'/../../Settings/Settings.php';
require __DIR__.'/../AM/AJAXManagerServer.php';

//Database Authentication and database selection variables
$DB_HOST = $mysqlDataBaseDetails['DB_HOST'];
$DB_USER = $mysqlDataBaseDetails['DB_USER'];
$DB_PASSWORD = $mysqlDataBaseDetails['DB_PASS'];
$DB_NAME = $mysqlDataBaseDetails['DB_NAME'];
 
$authObj = new AJAXManagerServer($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME, "PHPScriptAuth", "");
$authenticated = $authObj->Authenticate();
$dealers = "";

if($authenticated) {
	$q = $authObj->Query("");
	
	$db_Conn = mysqli_connect($mysqlDataBaseDetails['DB_HOST'],
							  $mysqlDataBaseDetails['DB_USER'],
							  $mysqlDataBaseDetails['DB_PASS'],
							  $mysqlDataBaseDetails['DB_NAME']);
	if(mysqli_error($db_Conn)) {
	}
	else {
		$query = "SELECT DISTINCT DealerName FROM UKDealers where DealerName LIKE '".
			     mysqli_real_escape_string($db_Conn, $q)."%' AND Active=1";
		$result = mysqli_query($db_Conn, $query);
		while($row = mysqli_fetch_array($result)) {
			$dealers .= $row['DealerName']."+";
		}
		if($dealers != "") { $dealers = rtrim($dealers, "+"); }
	} 
}

echo $authObj->Response($dealers);

?>