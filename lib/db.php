<?php
function getDB() {
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="slim_db";
	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass); 
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}
//$connection=getDB();
$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "slim_db";
try
{
    $DB_con=new PDO("mysql:host={$DB_host};dbname={$DB_name};",$DB_user,$DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
include("class.php");
$library=new crud($DB_con);
$data['library']=$library->getdataList();
//print_r($data);
?>