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
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        min-hegiht: 87vh;
        background-color: black;
        color: white;
        text-align: center;
    }
    </style>
</head>

<body>
    <?php include "partials/_header.php";?>
    <?php include "partials/_dbConnect.php";?>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_discription'];
    }
    
    ?>
    <?php
    error_reporting(0);
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    $showAlert=false;
    if($method=='POST'){
        // Insert into thread db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
         $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title); 

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc); 
        $sno=$_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `tstamp`) VALUES ('$th_title', '$th_desc', '1', '$sno', '2022-02-21 07:07:39.000000')";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> your thread has been added Please wait for community response
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

        }
    }
    ?>
    <!-- Categories container start from here -->
    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> Forum</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
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
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
         echo ' <div class="container">
        <form action="'. $_SERVER['REQUEST_URI'].'" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Problem Title </label>
                <input type="title" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep Your Title as short as possible</div>
            </div>
            <div class="form-group">
                <label for="desc">Describe Problem</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <input type="hidden" name="sno" value="'. $_SESSION['sno'].'">
        

            <button type="submit" class="btn btn-success">Submit</button>
        </form>



          </div>';
    }
    else{
        echo'
        <div class="container">
        <p class="lead">You are not Logged in</p>
        
        
        </div>';
        }
    ?>
    <div class="container">
        <h1 class="text-center py-2">Browse Question</h1>

        <?php
        $limit=2;
        $page=$_GET['page'];
        
        if(isset($_GET['page'])){
            $page=$_GET['page'];
        }
        else{
            $page=1;
        }
        $offset=($page-1)*$limit;
        $noResult=true;
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id LIMIT {$offset},{$limit}"; 
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $noResult=false;
            $id=$row["thread_id"];
            $title = $row['thread_title'];
            $desc =  $row['thread_desc'];
            $thread_user_id= $row['thread_user_id'];
            $thread_time=date('d-m-Y');
            $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
            $result2=mysqli_query($conn,$sql2);
            $row2=mysqli_fetch_assoc($result2);


            echo ' <div class="media my-3">
            <img src="images/img1.png" width="54px" class="mr-3" alt="...">
            <div class="media-body">'.
                '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
                '.$desc.'</div>'.'<p>'.$row2['user_email'].'at '.$thread_time.'</p>'.'
            </div>';  
        }
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">Result Not Found</h1>
              <p class="lead">Be a First Person To ask a Question</p>
            </div>
          </div>';
        }
        $sql1="SELECT * FROM `threads`";
        $result1=mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result)>0)
        {
            $total_records=mysqli_num_rows($result1);
            
            $total_pages=ceil($total_records/$limit);
            echo'<nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">';
               
                if($page>1){
                    echo'<a class="page-link" href="threadlist.php?catid='.$_GET['catid'].'&page='.($page-1).'">Previous</a>';
                }
           for ($i=1; $i <$total_pages ; $i++) { 
               echo '<li class="page-item"><a class="page-link" href="threadlist.php?catid='.$_GET['catid'].'&page='.$i.'">'.$i.'</a></li>';
           }
           if($total_pages>$page){
                echo'<a class="page-link" href="threadlist.php?catid='.$_GET['catid'].'&page='.($page+1).'">Next</a>';
            }
           echo'
             </ul>
            </nav>';
        }

        
       ?>
        <!-- later remove -->




        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>