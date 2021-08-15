<?php
    require_once "includes/db.php";
    include_once 'includes/dbPDO.php';
    include_once 'classes/page.php';

    $database = new Database();
    $db = $database->getConnection(); 

    $updatedItem = new Page($db);

    $updatedItem->id = $_POST['id'];
    $updatedItem->title = $_POST['title'];
    $updatedItem->adminId = $_POST['adminId'];

    if($updatedItem->deletePage()){
        header('location: deletepages.php');
    }
                    
?>