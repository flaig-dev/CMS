<?php
    require_once "includes/db.php";
    include_once 'includes/dbPDO.php';
    include_once 'classes/subject.php';

    $database = new Database();
    $db = $database->getConnection(); 

    $updatedItem = new Subject($db);

    $updatedItem->id = $_POST['id'];
    $updatedItem->title = $_POST['title'];
    $updatedItem->adminId = $_POST['adminId'];

    if($updatedItem->deleteSubject()){
        header('location: deletesubjects.php');
    }
                    
?>