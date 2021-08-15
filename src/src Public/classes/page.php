<?php
    class Page{

        // Connection
        private $conn;

        // Table
        private $db_table = "page";

        // Columns
        public $id;
        public $title;
        public $textBody;
        public $adminId;
        public $subjectId;
        public $dateCreated;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getPages(){
            $sqlQuery = "SELECT id, title, textBody, adminId, subjectId, dateCreated FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ pages by subject
        public function getSubjectPages(){
            $sqlQuery = "SELECT
                        id, 
                        title,
                        textBody,
                        adminId,
                        subjectId,
                        dateCreated
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       subjectId = ?";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->subjectId);

            $stmt->execute();

            $this->dataRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } 

        // READ single
        public function getSinglePage(){
            $sqlQuery = "SELECT
                        id, 
                        title,
                        textBody,
                        adminId,
                        subjectId,
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
            $this->textBody = $dataRow['textBody'];
            $this->adminId = $dataRow['adminId'];
            $this->subjectId = $dataRow['subjectId'];
            $this->dateCreated = $dataRow['dateCreated'];
        }        
    }
?>