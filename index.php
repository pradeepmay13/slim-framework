<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';


$app = new \Slim\App();

$app->get('/users','getUsers');
$app->get('/updates','getUserUpdates');
$app->post('/updates', 'insertUpdate');
$app->delete('/updates/delete/:update_id','deleteUpdate');
$app->get('/users/search/:query','getUserSearch');


//======================== Retrieving All Books ===========================================
$app->get('/books', function() { 
	require_once('lib/db.php'); 
	echo json_encode($data['library']); 
});

//======================== Creating a Book’s Record ===========================================

$app->post('/books', function($request){ 
	require_once('lib/db.php'); 
	$connection=getDB();
	$query = "INSERT INTO library (book_name,book_isbn,book_category) VALUES (?,?,?)"; 
	$stmt = $connection->prepare($query); 
	$stmt->bind_param("sss",$book_name,$book_isbn,$book_category); 
	$book_name = $request->getParsedBody()['book_name']; 
	$book_isbn = $request->getParsedBody()['book_isbn']; 
	$book_category = $request->getParsedBody()['book_category']; 
	$stmt->execute(); 
});

//======================== Updating a Book’s Record ===========================================

$app->put('/books/{book_id}', function($request){ 
	require_once('lib/db.php'); 
	$connection=getDB();
	$get_id = $request->getAttribute('book_id'); 
	$query = "UPDATE library SET book_name = ?, book_isbn = ?, book_category = ? WHERE book_id = $get_id"; 
	$stmt = $connection->prepare($query); 
	$stmt->bind_param("sss",$book_name,$book_isbn,$book_category); 
	$book_name = $request->getParsedBody()['book_name']; 
	$book_isbn = $request->getParsedBody()['book_isbn']; 
	$book_category = $request->getParsedBody()['book_category']; 
	$stmt->execute(); 
});

//======================== Deleting a Book’s Record ===========================================


$app->delete('/books/{book_id}', function($request){ 
	require_once('lib/db.php');
	$connection=getDB();
	$get_id = $request->getAttribute('book_id');
	$query = "DELETE from library WHERE book_id = $get_id";
	$result = $connection->query($query); 
});


/*
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->get('/friends', function (Request $request, Response $response) {
	$con=mysqli_connect("localhost","root","","slim_db");
	header("Content-Type: application/json");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql="SELECT id, name, job FROM friends";
	if ($result=mysqli_query($con,$sql))
	{
		while ($row=mysqli_fetch_row($result))
		{
			$data[] = $row;
		}
		//$res=json_encode($data);
		//mysqli_free_result($result);
		//print_r($data);
	}
	$newResponse = $oldResponse->withJson($data);
	//$response$newResponse;
	return $newResponse;
});

*/

$app->run();

?>


