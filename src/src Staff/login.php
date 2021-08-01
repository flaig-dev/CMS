<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect them to staff page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "includes/db.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, failedLoginAttempts FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $failed_login_attempts);
                        if(mysqli_stmt_fetch($stmt)){
                            // Check if account is blocked
                            if($failed_login_attempts < 5 ){
                                if(password_verify($password, $hashed_password)){
                                    // Password is correct, so start a new session
                                    session_start();
                            
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;                            
                            
                                    // Redirect user to staff page
                                    header("location: index.php");

                                    // Clear failed login attempts
                                    $sqlClearFailAttempt = "UPDATE users SET failedLoginAttempts = 0 WHERE users.id = ?";
                                    $stmtClearFailAttempt = mysqli_prepare($db, $sqlClearFailAttempt);
                                    mysqli_stmt_bind_param($stmtClearFailAttempt, "s", $param_id);
                                    $param_id = $id;
                                    mysqli_stmt_execute($stmtClearFailAttempt);

                                } else{
                                    // Password is not valid, display a generic error message
                                    $login_err = "Invalid username or password.";
                            
                                    // Increase failed login attempts
                                    $sqlInsertFailAttempt = "UPDATE users SET failedLoginAttempts = failedLoginAttempts + 1 WHERE users.id = ?";
                                    $stmtInsertFailAttempt = mysqli_prepare($db, $sqlInsertFailAttempt);
                                    mysqli_stmt_bind_param($stmtInsertFailAttempt, "s", $param_id);
                                    $param_id = $id;
                                    mysqli_stmt_execute($stmtInsertFailAttempt);
                                }
                            }/////testing
                            else{
                              // Account blocked
                              $login_err = "Account is permanetly blocked.";
                            }
                        }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="WEBD-325-45 Project: Login" />
  <meta name="author" content="Matthew R. Flaig" />
  <title>Login - SB Admin</title>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                <div class="card-body">
                
                <?php 
                if(!empty($login_err)){
                  echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }        
                ?>

                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-floating mb-3">
                      <input id="inputUsername" name="username" type="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                      <span class="invalid-feedback"><?php echo $username_err; ?></span>
                      <label for="inputUsername">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input id="inputPassword" name="password" type="password" placeholder="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                      <span class="invalid-feedback"><?php echo $password_err; ?></span>
                      <label for="inputPassword">Password</label>
                    </div>
                    <div class="form-check mb-3">
                      <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                      <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <a class="small"></a>
                      <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="mailto:email@example.com &subject=Requesting New Account for Website &body=Please create a new account for me.">Need an account? Email Us!</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
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