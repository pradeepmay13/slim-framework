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

?>