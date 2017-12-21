<?php  
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "slim_db";
header("Access-Control-Allow-Origin: *");
//print_r($_FILES);
$modelData=json_decode($_REQUEST['modelData'],true);
//die;
$path = 'uploads/';
if (isset($_FILES['file'])) {
  $originalName = $_FILES['file']['name'];
  $ext = '.'.pathinfo($originalName, PATHINFO_EXTENSION);
  $generatedName = md5($_FILES['file']['tmp_name']).$ext;
  $filePath = $path.$generatedName;
  
  if (!is_writable($path)) {
    echo json_encode(array(
      'status' => false,
      'msg'    => 'Destination directory not writable.'
    ));
    exit;
  }
 
  if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO upload_files (userId, fileOrigName, fileNewName, fileType, comment, created_date)
        VALUES ('1', '".$originalName."', '".$generatedName."', '".$ext."', '".$modelData['name']."', now())";
        $conn->exec($sql);
        if($conn)
        {
            echo json_encode(array(
              'status'        => true,
              'originalName'  => $originalName,
              'generatedName' => $generatedName
            ));
        }else{
            echo json_encode(array(
              'status'        => false,
              'msg'  => "Inserting data process failed: ".$conn,
            ));
        }
    }
    catch(PDOException $e)
    {
        echo json_encode(array(
          'status'        => false,
          'msg'           => $e->getMessage()
        ));
    }
  }
}
else {
  echo json_encode(
    array('status' => false, 'msg' => 'No file uploaded.')
  );
  exit;
}
?> 