<?php
$show_Error="false";
if($_SERVER=['REQUEST_METHOD']){
    $user_email=$_POST['email_Sign'];
    $user_pass=$_POST['password_Sign'];
    $user_cpass=$_POST['cpassword_Sign'];
    include "_dbConnect.php";

    $sql_Exist= "select * from `users`where user_email='$user_email'";
    $result=mysqli_query($conn,$sql_Exist);
    $rows=mysqli_num_rows($result);
    if($rows>0){
        $show_Error='Email already in use';
    }
    else{
        if($user_pass==$user_cpass){
            $hash=password_hash($user_pass,PASSWORD_DEFAULT);
            $sql="INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            if($result){
                $show_Alert=true;
                header("Location:/forum/index.php?signupsuccess=true");
                exit;

            } 
        }
        else{ 
            $show_Error='password do not match';
            

        }
    }
    header("Location:/forum/index.php?signupsuccess=false");

}






?>