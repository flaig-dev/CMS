<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "includes/db.php";
include_once 'includes/dbPDO.php';
include_once 'classes/subject.php';

$database = new Database();
$db = $database->getConnection();

$items = new Subject($db);

$stmt = $items->getSubjects();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="WEBD-325-45 Project: Delete Subjects" />
  <meta name="author" content="Matthew R. Flaig" />
  <title>Branding - Staff</title><!--Future DB Content-->
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php">Branding: Delete Subjects</a><!--Future DB Content-->
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="login.php">Login</a></li>
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Manage Users</div>
            <a class="nav-link" href="users.php">
              <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
              Users
            </a>
            <div class="sb-sidenav-menu-heading">Manage Content</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSubjects" aria-expanded="false" aria-controls="collapseSubjects">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Subjects
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseSubjects" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="createsubjects.php">Create Subjects</a>
                <a class="nav-link" href="editsubjects.php">Edit Subjects</a>
                <a class="nav-link" href="deletesubjects.php">Delete Subjects</a>
              </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
              <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
              Pages
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="createpages.php">Create Pages</a>
                <a class="nav-link" href="editpages.php">Edit Pages</a>
                <a class="nav-link" href="deletepages.php">Delete Pages</a>
              </nav>
            </div>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          Username <!--Future DB Content-->
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Branding</h1><!--Future DB Content-->
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Flavor Text Branding</li><!--Future DB Content-->
          </ol>
        </div>
        <div class="container">
            <div class="card push-top">
            <div class="card-header">
                Subjects
            </div>
            <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">Title</th>
                    <th scope="col">AdminID</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   while($row = $stmt->fetch()) {
                                echo "<tr><td scope='row'>" . $row['title'] . "</td><td>" . $row['adminId'] . "</td><td>" . $row['dateCreated'] . "</td><td><a href='deletesubject.php?id={$row['id']}'>Delete</a></td></tr>";
                            } 
                    ?>
                </tbody>
            </table>
            </div>
            </div>
        </div>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2021</div><!--Future DB Content-->
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>
</html>