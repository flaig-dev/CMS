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
  $subjectItem->id = isset($_GET['subjectId']) ? $_GET['subjectId'] : die();
  $subjectItem->getSingleSubject();

  $subjectList = new Subject($db);
  $subjectList->getSubjectList();

  $pageItem = new Page($db);
  $pageItem->id = isset($_GET['id']) ? $_GET['id'] : die();
  $pageItem-> getSinglePage();

  //Assign values to template variables
  $smarty->assign('heading', $subjectItem->title);
  $smarty->assign('title', $pageItem->title);
  $smarty->assign('paragraph', $pageItem->textBody);
  $smarty->assign('subjects', $subjectList->dataSubRows);

    //display our page
  $smarty->display('extends:layout.tpl|indexPage.tpl'); 
?>