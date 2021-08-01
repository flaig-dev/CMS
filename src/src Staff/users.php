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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="WEBD-325-45 Project: Users" />
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
    <a class="navbar-brand ps-3" href="index.php">Branding: Users</a><!--Future DB Content-->
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

  <!-- Page header with logo and tagline-->
  <header class="py-5 bg-light border-bottom mb-4">
    <div class="container">
      <div class="text-center my-5">
        <h1 class="fw-bolder">Users Temp Registration</h1>
        <p class="lead mb-0">Creation tool for testing</p>
      </div>
    </div>
  </header>
  <!-- Page content-->
  <div class="container">
    <div class="row">
      <!-- Blog entries-->
      <div class="col-lg-8">
        <!-- Featured blog post-->
        
        <?php
 
          // Define variables and initialize with empty values
          $username = $password = $confirm_password = "";
          $username_err = $password_err = $confirm_password_err = "";
 
          // Processing form data when form is submitted
          if($_SERVER["REQUEST_METHOD"] == "POST"){
 
              // Validate username
              if(empty(trim($_POST["username"]))){
                  $username_err = "Please enter a username.";
              } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
                  $username_err = "Username can only contain letters, numbers, and underscores.";
              } else{
                  // Prepare a select statement
                  $sql = "SELECT id FROM users WHERE username = ?";
        
                  if($stmt = mysqli_prepare($db, $sql)){
                      // Bind variables to the prepared statement as parameters
                      mysqli_stmt_bind_param($stmt, "s", $param_username);
            
                      // Set parameters
                      $param_username = trim($_POST["username"]);
            
                      // Attempt to execute the prepared statement
                      if(mysqli_stmt_execute($stmt)){
                          /* store result */
                          mysqli_stmt_store_result($stmt);
                
                          if(mysqli_stmt_num_rows($stmt) == 1){
                              $username_err = "This username is already taken.";
                          } else{
                              $username = trim($_POST["username"]);
                          }
                      } else{
                          echo "Oops! Something went wrong. Please try again later.";
                      }

                      // Close statement
                      mysqli_stmt_close($stmt);
                  }
              }
    
              // Validate password
              if(empty(trim($_POST["password"]))){
                  $password_err = "Please enter a password.";     
              } elseif(strlen(trim($_POST["password"])) < 6){
                  $password_err = "Password must have atleast 6 characters.";
              } else{
                  $password = trim($_POST["password"]);
              }
    
              // Validate confirm password
              if(empty(trim($_POST["confirm_password"]))){
                  $confirm_password_err = "Please confirm password.";     
              } else{
                  $confirm_password = trim($_POST["confirm_password"]);
                  if(empty($password_err) && ($password != $confirm_password)){
                      $confirm_password_err = "Password did not match.";
                  }
              }
    
              // Check input errors before inserting in database
              if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
                  // Prepare an insert statement
                  $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
                  if($stmt = mysqli_prepare($db, $sql)){
                      // Bind variables to the prepared statement as parameters
                      mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
                      // Set parameters
                      $param_username = $username;
                      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
                      // Attempt to execute the prepared statement
                      if(mysqli_stmt_execute($stmt)){
                          // Redirect to login page
                          echo "User created.";
                      } else{
                          echo "Oops! Something went wrong. Please try again later.";
                      }

                      // Close statement
                      mysqli_stmt_close($stmt);
                  }
              }
    
              // Close connection
              mysqli_close($db);
          }
          ?>

              <div class="wrapper">
                  <h2>Register New User</h2>
                  <p>Please fill this form to create an account.</p>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group">
                          <label>Username</label>
                          <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                          <span class="invalid-feedback"><?php echo $username_err; ?></span>
                      </div>    
                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                          <span class="invalid-feedback"><?php echo $password_err; ?></span>
                      </div>
                      <div class="form-group">
                          <label>Confirm Password</label>
                          <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                          <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                      </div>
                      <div class="form-group">
                          <input type="submit" class="btn btn-primary" value="Submit">
                          <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                      </div>
                  </form>
              </div>    

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