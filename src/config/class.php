<?php

class crud {

    private $db; // private variable define
    protected $db_new; // private variable define
    public $dbpublic; // private variable define

    function __construct($DB_con) { //call anywhere with this construct function
        $this->db = $DB_con; // for same
        $this->db_new = $DB_con; // for extends class
        $this->dbpublic = $DB_con; // for extends class
    }

    public function getdataList() {
        $select_stmt = $this->db->prepare("SELECT * FROM library ORDER BY book_id ");
        $select_stmt->execute();
        $dataList = $select_stmt->fetchALL(PDO::FETCH_ASSOC);
        return $dataList;
    }
    public function getdata($data) {
        $select_stmt = $this->db->prepare("SELECT * FROM library where book_id=:id ");
        $select_stmt->bindParam(':id', $data, PDO::PARAM_INT);
        $select_stmt->execute();
        //$select_stmt->debugDumpParams();
        $count = $select_stmt->rowCount();
        if($count>0){
            $dataList = $select_stmt->fetch(PDO::FETCH_ASSOC);
            return $dataList;
        }else{
            return false;
        }        
    }
    public function insertBook($data) {
        $insert_stmt = $this->db->prepare("INSERT INTO library(book_name,book_isbn,book_category) VALUES(:book_name,:book_isbn,:book_category)");
        $insert_stmt->bindParam(":book_name", $data['book_name']);
        $insert_stmt->bindParam(":book_isbn", $data['book_isbn']);
        $insert_stmt->bindParam(":book_category", $data['book_category']);
        $insert_stmt->execute();
        //$insert_stmt->debugDumpParams();
        return $insert_stmt;
    }
    public function updateRecord($data) {
        $stmt = $this->db->prepare("UPDATE library SET book_name=:book_name, book_isbn=:book_isbn, book_category=:book_category WHERE book_id = :book_id");
        $stmt->bindParam(":book_name", $data['book_name']);
        $stmt->bindParam(":book_isbn", $data['book_isbn']);
        $stmt->bindParam(":book_category", $data['book_category']);
        $stmt->bindParam(":book_id", $data['id']);
        $stmt->execute();
        //$stmt->debugDumpParams();
        return $stmt;
    }
    public function deleteRecord($data){
        $query = "DELETE from library WHERE book_id = $data";
	$result = $this->db->prepare($query); 
        $result->execute();
        return $result;
    }
}
class authuser extends crud
{
    public function login($data)
    {
        try
        {
            $username=stripslashes($data['username']);
            $password=stripslashes($data['password']);
            if(isset($username) && isset($password) && !empty($username) && !empty($password))
            {
                $login_stmt=$this->db_new->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
                $login_stmt->bindParam(":username",$username);
                $login_stmt->bindParam(":password",$password);
                $login_stmt->execute();     
                if($login_stmt->rowCount()>0)
                {
                    $row=$login_stmt->fetch(PDO::FETCH_ASSOC);
                    if($row['status']=='1')
                    {
                        $_SESSION['id']=session_id();
                        $_SESSION['user_id']=$row['user_id'];
                        $token = $username . " | " . uniqid() . uniqid() . uniqid();
                        $tokenStore = "UPDATE users SET token=:token WHERE username=:username AND password=:password";
                        $query = $this->db_new->prepare($tokenStore);
                        $execute = $query->execute(array(
                            ":token" => $token,
                            ":username" => $username,
                            ":password" => $password,
                        ));
                        $res = array(
                            "message" => "Success",
                            "username" => $username,
                            "execution" => "1",
                            "token" => $token
                        );
                        return json_encode($res);
                    }
                    else
                    {
                        $res = array(
                            "message" => "Username or Password is wrong",
                            "username" => $username,
                            "execution" => "0"
                        );
                        return json_encode($res);
                    }
                }
                else
                {
                    $res = array(
                        "message" => "Username or Password is wrong",
                        "username" => $username,
                        "execution" => "0"
                    );
                    return json_encode($res);
                }
            }
            else
            {
                $res = array(
                    "message" => "Username or Password is missing",
                    "username" => $username,
                    "execution" => "0"
                );
                return json_encode($res);
            }
        }
        catch(PDOException $e)
        {
            $e->getMessage();
            $res = array(
                "message" => $e->getMessage(),
                "username" => $username,
                "execution" => "0"
            );
            return json_encode($res);
        }
    }
    public function logout($data){
        try
        {
            $token=stripslashes($data);
            $queryString="UPDATE users SET token='logged out' WHERE token=:token";
            $stmt = $this->db_new->prepare($queryString);
            $stmt->execute(array(":token" => $token));
            return $stmt;
        }
        catch(PDOException $e)
        {
            $e->getMessage();
            return json_encode($res);
        }
    }
}
?>