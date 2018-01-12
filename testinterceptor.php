<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
//header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
$headers = apache_request_headers();
print_r($headers['Authorization']);
if($_SERVER['REQUEST_METHOD']=="OPTIONS"){
	return true;
}
else{
	$rawData = file_get_contents("php://input");
	print_r($rawData);
}
?>
