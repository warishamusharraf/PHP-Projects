<?php
$servername="localhost";
$username="root";
$password="";
$database="users";

$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("Found Error ".mysqli_connect_error());
}
else{
    "connection success";
}


?>