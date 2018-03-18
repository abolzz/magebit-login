<?php
// Include config file
require_once 'connection.php';

 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
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
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
<div class="account account-right">
		<h1>Have an account?</h1>
		<hr>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
		<button type="submit" action="signup.php" class="button button-blue">
		<a href="index.php">Login</a>
		</button>
	</div>
<div class="loginWrapper loginWrapper-left"></div>
					<div class="active signup">
                        <div class="signupHeader">
						<h1>Sign Up</h1>
						  <img src="img/logo.png" alt="Magebit logo" class="logo">
                        </div>
						<hr>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<div class="inputs <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
								<input type="text" name="username" placeholder="Name*" value="<?php echo $username; ?>" required>
								<span class="help-block"><?php echo $username_err; ?></span>
								<img src="img/ic_user.png" alt="User icon">
							</div>
							<div class="inputs">
								<input type="email" name="email" id="email" placeholder="Email*" required>
								<img src="img/ic_mail.png" alt="Mail icon">
							</div>
							<div class="inputs <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
								<input type="password" name="password" id="password" placeholder="Password*" value="<?php echo $password; ?>" required>
								<img src="img/ic_lock.png" alt="Lock icon">
							</div>
							<div class="loginAction">
								<button type="submit" value="Submit" class="button button-orange" action="welcome.php">Sign Up</button>
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