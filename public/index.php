<?php session_start();
//$a = '1';$ax="1";
//$b = &$a;$bx = &$ax;
//$b = "2$b";$bx = "2$bx";
//echo $ax.", ".$bx;
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
include('../src/config/db.php');
include("../src/config/class.php");
$app = new \Slim\App();
$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';
$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};
//$app->add($container->get('csrf'));

$app->post('/uploadfile', function(Request $request, Response $response) {
    $directory = $this->get('upload_directory');
    $uploadedFiles = $request->getUploadedFiles();
    // handle single input with single file upload
    if(isset($uploadedFiles['example1'])){
        $uploadedFile = $uploadedFiles['example1'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename['newFileName'] . '<br/>');
        }
    }    
    if(isset($uploadedFiles['example2'])){
        // handle multiple inputs with the same key
        foreach ($uploadedFiles['example2'] as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = moveUploadedFile($directory, $uploadedFile);
                $response->write('uploaded ' . $filename['newFileName'] . '<br/>');
            }            
        }
    }
    
    if(isset($uploadedFiles['example3'])){
        // handle single input with multiple file uploads
        foreach ($uploadedFiles['example3'] as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = moveUploadedFile($directory, $uploadedFile);
                $response->write('uploaded ' . $filename['newFileName'] . '<br/>');
            }
        }
    }
});


function moveUploadedFile($directory, $uploadedFile)
{    
    $original_name=$uploadedFile->getClientFilename();
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $newFileName=md5(time().rand('111111','99999999').  DateTime::ATOM).".".$extension;  

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $newFileName);
    //print_r($uploadedFile->getClientFilename());echo "<br>";
    return array("original_name"=>$original_name, "newFileName"=>$newFileName);
}

//======================== Test Data ===========================================


$app->get('/hello/{name}', function (Request $request, Response $response) { 
    $nameKey = $this->csrf->getTokenNameKey();
    $valueKey = $this->csrf->getTokenValueKey();
    $name = $request->getAttribute($nameKey);
    $value = $request->getAttribute($valueKey);
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
})->add($container->get('csrf'));

//$app->get('/users','getUsers');
//$app->get('/updates','getUserUpdates');
//$app->post('/updates', 'insertUpdate');
//$app->delete('/updates/delete/:update_id','deleteUpdate');
//$app->get('/users/search/:query','getUserSearch');


//======================== Retrieving All Books ===========================================
$app->get('/books', function(Request $request, Response $response) { 
	$db=new db();
        $library=new crud($db->connect());
        $data['library']=$library->getdataList();         
	if($data['library']){
            $dataset=$data['library']; 
            //$status = $response->getStatusCode();
            return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dataset));
        }
	else{
            $dataset= array('error'=>true, 'data'=>$data);
            return $response->withStatus(503)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dataset));
        }
});


//======================== Retrieving one Book ===========================================
$app->get('/books/{book_id}', function(Request $request, Response $response) { 
    $db=new db();
    $library=new crud($db->connect());
    $get_id = $request->getAttribute('book_id');
    $data=$library->getdata($get_id);
    if($data==true){
        $dataset=$data; 
        //$status = $response->getStatusCode();
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }
    elseif($data==0){
        $dataset= array('error'=>true, 'data'=>$data);
        return $response->withStatus(417)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }
    else{
        $dataset= array('error'=>true, 'data'=>$data);
        return $response->withStatus(503)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }
});


//======================== Creating a Books Record ===========================================

$app->post('/books/add', function(Request $request, Response $response) {
    //$x=file_get_contents('php://input');    
    $db=new db();
    $library=new crud($db->connect());
    $data['book_name'] = $request->getParam('book_name');
    $data['book_isbn'] = $request->getParam('book_isbn');
    $data['book_category'] = $request->getParam('book_category');
    $result = $library->insertBook($data);
    if ($result){
        $dataset=array("execution"=>true);
        //$status = $response->getStatusCode();
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }else{
        $dataset= array('execution'=>false, 'data'=>$result);
        return $response->withStatus(503)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }
});

//======================== Updating a Books Record ===========================================

$app->put('/books/{book_id}', function(Request $request, Response $response){
    $db=new db();
    $library=new crud($db->connect());
    $data['book_name'] = $request->getParsedBody()['book_name']; 
    $data['book_isbn'] = $request->getParsedBody()['book_isbn']; 
    $data['book_category'] = $request->getParsedBody()['book_category']; 
    $data['id'] = $request->getAttribute('book_id');
    $result=$library->updateRecord($data);    
    if ($result){
        $dataset=array("execution"=>true);
        return $response->withStatus($response->getStatusCode())
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }else{
        $dataset= array('execution'=>false, 'data'=>$result);
        return $response->withStatus(503)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }    
});

//======================== Deleting a Books Record ===========================================


$app->delete('/books/{book_id}', function(Request $request, Response $response){ 
    $db=new db();
    $library=new crud($db->connect());
    $get_id = $request->getAttribute('book_id');
    $result=$library->deleteRecord($get_id);
    if ($result){
        $dataset=array("execution"=>true);
        return $response->withStatus($response->getStatusCode())
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }else{
        $dataset= array('execution'=>false, 'data'=>$result);
        return $response->withStatus(503)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }
});


//======================== Login ===========================================
$app->post('/login', function(Request $request, Response $response, $args) {     
    $db=new db();
    $auth=new authuser($db->connect());    
    //$formData = json_decode(file_get_contents('php://input'), true);
    $reqData=json_decode($request->getBody(),true);
    $data['username'] = $reqData['username'];
    $data['password'] = $reqData['password'];
    $result=json_decode($auth->login($data),true);    
    if($result['execution']=="1"){
        $dataset=$result; 
        //$status = $response->getStatusCode();
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }
    else{
        $dataset= array('error'=>true, 'data'=>$result);
        return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($dataset));
    }
});
//======================== Logout ===========================================
$app->post('/logout', function(Request $request, Response $response, $args) {     
    $db=new db();
    $auth=new authuser($db->connect());    
    $reqData=$request->getBody();
    if(isset($reqData)){
        $token=json_decode($reqData,true);
        $result=$auth->logout($token);    
        if ($result){
            $dataset=array("execution"=>true);
            return $response->withStatus($response->getStatusCode())
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dataset));
        }else{
            $dataset= array('execution'=>false, 'data'=>$result);
            return $response->withStatus(201)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dataset));
        }
    }
});


//======================== Login ===========================================
$app->post('/user', function(Request $request, Response $response, $args) {     
    $db=new db();
    $auth=new authuser($db->connect());
	$token=$request->getBody();
    if(isset($token)){        
        $result=$auth->getUser($token);
        if ($result){
            $dataset=array("execution"=>true, "resultSet"=>$result);
            return $response->withStatus($response->getStatusCode())
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dataset));
        }else{
            $dataset= array('execution'=>false, 'resultSet'=>$result);
            return $response->withStatus($response->getStatusCode())
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($dataset));
        }
    }
});

$app->run();
?>


