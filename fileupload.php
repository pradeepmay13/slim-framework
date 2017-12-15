<?php 
 
header("Access-Control-Allow-Origin: *");
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(array('status' => false));
  exit;
}
 
$path = 'uploads/';
$data=file_put_contents($payload['avatar']['filename'], base64_decode($payload['avatar']['value']));
 print_r($data);die;
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
    echo json_encode(array(
      'status'        => true,
      'originalName'  => $originalName,
      'generatedName' => $generatedName
    ));
  }
}
else {
  echo json_encode(
    array('status' => false, 'msg' => 'No file uploaded.')
  );
  exit;
}
 
?> 