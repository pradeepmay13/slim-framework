<?php 
class crud
{
    private $db; // private variable define
    protected $db_new; // private variable define
    public $dbpublic; // private variable define
    function __construct($DB_con) //call anywhere with this construct function
    {
        $this->db=$DB_con; // for same
        $this->db_new=$DB_con; // for extends class
        $this->dbpublic=$DB_con; // for extends class
    }
	public function getdataList()
    {
        $select_stmt=$this->db->prepare("SELECT * FROM library ORDER BY book_id ");
        $select_stmt->execute();
        $dataList=$select_stmt->fetchALL(PDO::FETCH_ASSOC);
        return $dataList;
    }
}

?>