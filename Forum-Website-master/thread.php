<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>iDiscuss Forum</title>
    <style>
    .footer {
    position:fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    min-hegiht:87vh;
    background-color: black;
    color: white;
    text-align: center;
    }
    </style>
</head>

<body>
    <?php include "partials/_dbConnect.php";?>
    <?php include "partials/_header.php";?>
    <?php
    $noResult=true;
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $noResult=false;
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        // Query the users table to find out the name of OP
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
    }
    
    ?>
    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    $showAlert=false;
    if($method=='POST'){
        // Insert into thread db
        $comment_content= $_POST['desc'];
        $comment = str_replace("<", "&lt;", $comment_content);
        $comment = str_replace(">", "&gt;", $comment_content); 
        $sno=$_POST['sno'];

        $sql="INSERT INTO `comments` (`comment_content`, `comment_by`, `thread_id`, `comment_time`) VALUES ('$comment_content','$sno', '$id', '2022-02-21 13:17:38.000000');";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> your Comment has been post! Thanks
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

        }
    }
    ?>
    <!- <!-- Categories container start from here -->
        <div class="container my-3">
            <div class="jumbotron">
                <h1 class="display-4"><?php echo $title ; ?></h1>
                <p class="lead"><?php echo $desc ;?></p>
                <p><b>Posted By <?php echo  $posted_by ; ?> </b></p>
                <hr class="my-4">
                <h3>Follow Rules </h3>
                <p>No Spam / Advertising / Self-promote in the forums not allowd<br>
                    Do not post copyright-infringing material.<br>
                    Do not post “offensive” posts, links or images.<br>
                    Do not cross post questions. <br>
                    Do not PM users asking for help.<br>
                    Remain respectful of other members at all times.</p>
                <p class="lead">
                    <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
                </p>
              
            </div>
        </div>
        <?php
     include '_postComment.php';

     ?>

        <div class="container">
            <h1 class="text-center py-2">Disscussion</h1>

            <?php
        $noResult=true;
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id = $id"; 
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $noResult=false;
            $id=$row["comment_id"];
            $content = $row['comment_content'];
            $content_time= $row['comment_time'];
             $thread_user_id = $row['comment_by']; 
            $sql2 = "SELECT  `user_email` FROM `users` WHERE sno='$thread_user_id'";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);
            $time=date('d-m-Y');
            
                echo '<div class="media my-3">
                <img src="images/img1.png" width="54px" class="mr-3" alt="...">
                <div class="media-body">
                <p class="font-weight-bold my-0">'. $row2['user_email'] .' at '. $time. '</p> '. $content . '
                </div>
               </div>';
                }
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">Result Not Found</h1>
              <p class="lead">Be a First Person To Post A Comment</p>
            </div>
          </div>';
        }
        
       ?>




            <!-- later remove -->


            <?php include "partials/_footer.php"?>
            <!-- Optional JavaScript; choose one of the two! -->

            <!-- Option 1: Bootstrap Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous">
            </script>

            <!-- Option 2: Separate Popper and Bootstrap JS -->
            <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>