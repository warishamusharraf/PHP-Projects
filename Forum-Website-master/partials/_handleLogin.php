<?php
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email = $_POST['email_login'];
    $pass = $_POST['password_login'];

    $sql = "Select * from users where user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['useremail'] = $email; 
            $_SESSION['sno']=$row['sno'];
            header("Location:/forum/index.php?loginsuccess=true");
            exit();
            }         
        }
        header("Location:/forum/index.php?loginsuccess=false");
         
        

}

?>