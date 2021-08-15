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

        // CREATE
        public function createPage(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        title = :title,
                        textBody = :textBody,
                        adminId = :adminId,
                        subjectId = :subjectId";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->textBody=htmlspecialchars(strip_tags($this->textBody));
            $this->adminId=htmlspecialchars(strip_tags($this->adminId));
            $this->subjectId=htmlspecialchars(strip_tags($this->subjectId));
        
            // bind data
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":textBody", $this->textBody);
            $stmt->bindParam(":adminId", $this->adminId);
            $stmt->bindParam(":subjectId", $this->subjectId);
        
            if($stmt->execute()){
               return true;
            }
            return false;
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

        // UPDATE
        public function updatePage(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        title = :title,
                        textBody = :textBody,
                        adminId = :adminId,
                        subjectId = :subjectId
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->textBody=htmlspecialchars(strip_tags($this->textBody));
            $this->adminId=htmlspecialchars(strip_tags($this->adminId));
            $this->subjectId=htmlspecialchars(strip_tags($this->subjectId));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":textBody", $this->textBody);
            $stmt->bindParam(":adminId", $this->adminId);
            $stmt->bindParam(":subjectId", $this->subjectId);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deletePage(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>