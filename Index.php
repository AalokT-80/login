<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: login.html");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: main.html");
                            
                        }
                    }

                }

    }
}    
}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>SITRC LOGIN PAGE</title>
      <link rel="stylesheet" href="register.css">
  </head>
  <body class="container">
<div class="container">
<h3 class="aligncenter">Please Login Here:</h3>
<hr>

<form action="main.html" method="post">
  <div class="textdecoration">
    <label for="username">Username:</label>
    <div><input type="text" name="username" class="form-control" id="username" placeholder="Enter Username"></div>
  </div>
  <div class="textdecoration">
    <label for="password">Password:</label>
    <div><input type="password" name="password" class="form-control" id="password" placeholder="Enter Password"></div>
  </div>
  <button type="submit" class="button1">Submit</button>
</form>
<p class="aligncenter textdecoration">For Registeration: <a href="registration.php">(click here)</a></p>
  </body>
</html>
