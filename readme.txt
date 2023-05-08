<?php
require_once 'config.php';
$username= $password = $confirm_password='';
$username_err= $password_err = $confirm_password_err='';

if($_SERVER['REQUEST_METHOD']=='POST'){
    //checking if it is empty
    if(empty(trim($_POST))){
        $username_err='USERNAME CANNOT BE BLANK';
    }
    else{
        $sql="SELECT id FROM users WHERE username=?";
        $stmt=mysqli_prepare($conn,$sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stnt,"s",$param_username);
            //set the value of param value

            $param_username=trim($_POST['username']);
            //Try to execute this statement  
            if($mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt)==1)
                {
                    $username_err="This username is already taken";
                }
                else{
                    $username=trim($_POST['username']);
                }
            }
            else{
                echo "SOMETHING WENT WRONG";
            }

        }
    }
    mysqli_stmt_close($stmt);
//check for password
if(empty(trim($_POST['password']))){
    $password_err="PASSWORD CANNOT BE BLANK!";
}
elseif(strlen(trim($_POST['password']))<5){
    $password_err="PASSWORD CANNOT BE LESS THAN 5 CHARACTERS!";
}
else{
    $password=trim($_POST['password']);
}

//checking for confirm password field
if(trim($_POST['password'])!=trim($_POST['confirm_password'])){
    $password_err="PASSWORD DOES NOT MATCH";
}

//If there were no errors, go ahead and insert into the database
if(empty($username_err)&& empty($password_err) &&empty($confirm_password_err)){
    $sql="INSERT INTO users(username,passowrd) VALUES(?,?)";
    $stmt=mysqli_prepare($conn,$sql);
    if($stmt)
    {
        mysqli_stmt_bind_param($stmt,"ss", $param_username,$param_password);
        //set these parameters
        $param_username=$username;
        $param_password=password_hash($password,PASSWORD_DEFAULT);
        //Try to execute the querery
        if($mysqli_stmt_execute($stmt)){
            header('location:login.php');
        }
        else{
            echo "SOMETHING WENT WRONG, CANNOT REDIRECT!!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Student Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200&family=Mallanna&family=Overlock&family=Ubuntu+Condensed&family=Ubuntu:wght@300&family=Yanone+Kaffeesatz:wght@300&display=swap" rel="stylesheet">
    <style>
      /* add some styles to make the login form look nice */
      body {
        font-family: 'Mallanna', sans-serif;
        background-color: #f2f2f2;
      }
      
      .login-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px #ccc;
        max-width: 400px;
        margin: 0 auto;
        margin-top: 50px;
      }
      
      .login-form input[type=text], 
      .login-form input[type=password] {
        width: 100%;
        padding: 10px;
        margin: 5px 0 15px 0;
        border: none;
        border-radius: 3px;
        background-color: #f2f2f2;
      }
      
      .login-form input[type=submit] {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 3px;
        padding: 10px;
        cursor: pointer;
        width: 100%;
        margin-bottom: 15px;
      }
      
      .login-form input[type=submit]:hover {
        background-color: #45a049;
      }
      
      .login-form h2 {
        text-align: center;
        margin-bottom: 30px;
      }
    </style>
  </head>
  <body>
    <form class="login-form" action="" method="post">
      <h2>Registration Page</h2>
      <label for="Name">Name:</lablel>
      <input type="text" id="name" name="name" placeholder="Enter your Full Name here">
      <label for="Username">Username:</label>
      <input type="text" id="username" name="username" placeholder="Enter your username">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password">
      <label for="confirm password">Confirm Password:</label>
      <input type="password" id="confirm password" name="confirm_password" placeholder="Confirm Password">
      <input type="submit" value="Register">
    </form>
  </body>
</html>
