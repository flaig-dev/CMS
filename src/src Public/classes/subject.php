<?php
    class Subject{

        // Connection
        private $conn;

        // Table
        private $db_table = "subject";

        // Columns
        public $id;
        public $title;
        public $adminId;
        public $dateCreated;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getSubjects(){
            $sqlQuery = "SELECT id, title, adminId, dateCreated FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getSingleSubject(){
            $sqlQuery = "SELECT
                        id, 
                        title, 
                        adminId, 
                        dateCreated
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->title = $dataRow['title'];
            $this->adminId = $dataRow['adminId'];
            $this->dateCreated = $dataRow['dateCreated'];
        }        
    }
?>