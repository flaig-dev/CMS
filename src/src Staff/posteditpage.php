<?php
    require_once "includes/db.php";
    include_once 'includes/dbPDO.php';
    include_once 'classes/page.php';

    $database = new Database();
    $db = $database->getConnection(); 

    $updatedItem = new Page($db);

    $updatedItem->id = $_POST['id'];
    $updatedItem->title = $_POST['title'];
    $updatedItem->textBody = $_POST['textBody'];
    $updatedItem->adminId = $_POST['adminId'];
    $updatedItem->subjectId = $_POST['subjectId'];

    if($updatedItem->updatePage()){
        header('location: editpages.php');
    }
                    
?>