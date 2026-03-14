<?php
$servername = "localhost";
$username ="root";
$password ="";
$database = "db_cosmetic";

$conn = new mysqli ($servername , $username , $password, $database);

   if($conn->connect_error)
   {
   die ("connection error ...." .$conn->connect_error);
   } 
   ?>