<?php
  //must be included in every script    
  require_once 'includes/smarty/configs/config.php';
  require_once "includes/db.php";
  include_once 'includes/dbPDO.php';
  include_once 'classes/subject.php';
  include_once 'classes/page.php';

  $database = new Database();
  $db = $database->getConnection();

  $subjectItem = new Subject($db);
  $subjectItem->id = isset($_GET['id']) ? $_GET['id'] : die();
  $subjectItem->getSingleSubject();

  $subjectList = new Subject($db);
  $subjectList->getSubjectList();

  $pageItem = new Page($db);
  $pageItem->subjectId = $subjectItem->id;
  $pageItem-> getSubjectPages();


  //Assign values to template variables
  $smarty->assign('heading', $subjectItem->title);
  $smarty->assign('paragraph', 'Please select a page to view.');
  $smarty->assign('pages', $pageItem->dataRows);
  $smarty->assign('subjects', $subjectList->dataSubRows);

    //display our page
  $smarty->display('extends:layout.tpl|indexSubject.tpl'); 
?>