<?php
// Include config file
require_once 'connection.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
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
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;      
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = 'No account found with that username.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Front page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Test task for Magebit">
    <meta name="author" content="Davis">
	<!-- Main stylesheet -->
	<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<body>
<div class="wrapper">
<div class="accountWrapper"></div>
<div class="account account-left">
	<h1>Don't have an account?</h1>
	<hr>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.	</p>
	<button type="submit" class="button button-blue">
	<a href="register.php">Sign up</a>
	</button>
</div>
<div class="loginWrapper loginWrapper-right"></div>
					<div class="active login">
						<div class="signupHeader">
							<h1>Login</h1>
							<img src="img/logo.png" alt="Magebit logo" class="logo">
						</div>
						<hr>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<div class="inputs">
								<input type="text" name="username" placeholder="Email*" required>
								<img src="img/ic_mail.png" alt="Mail icon" value="<?php echo $username; ?>">
							</div>
							<div class="inputs">
								<input type="password" name="password" placeholder="Password*" required>
								<img src="img/ic_lock.png" alt="Lock icon">
							</div>
							<div class="loginAction">
								<button type="submit" class="button button-orange" value="Login">Login</button>
								<a href="#" class="forgot">Forgot?</a>
							</div>
						</form>
					</div>
		<footer>
            All rights reserved "Magebit" 2016.
        </footer>
</div>
<script src="js/scripts.js"></script>
</body>
</html>