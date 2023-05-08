<?php
/*
This file contains database configuration where user is "root" and password is ""
*/ 
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','login');
//trying to get connected to database
$conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
//checking connection
if($conn==false){
    dir('Error:Cannot get connected');
}

?>