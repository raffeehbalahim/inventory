<?php

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
 
// Include config file
require_once "../db/config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $_SESSION["username_err"] = "Please enter username.";
    } else{
        $_SESSION["username_err"] = "";
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $_SESSION["password_err"] = "Please enter your password.";
    } else{
        $_SESSION["password_err"] = "";
        $password = trim($_POST["password"]);
    }

    if(!$username_err) {
        header("location: ../login.php");
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        
        // Prepare a select statement
        $sql = "SELECT id, username, password, user_type FROM users WHERE username = ?";
        
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
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $user_type);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = trim($_POST["username"]);  
                            $_SESSION["user_type"] = $user_type;                            
                            
                            // Redirect user to welcome page
                            header("location: ../index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $_SESSION["login_err"] = "Invalid username or password.";
                            header("location: ../login.php");
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $_SESSION["login_err"] = "Invalid username or password.";
                }
            } else{
                $_SESSION["login_err"] = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }  
}
?>
 