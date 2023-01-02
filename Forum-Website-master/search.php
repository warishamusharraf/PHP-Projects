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
    <?php include "partials/_dbConnect.php";?>
    <?php include "partials/_header.php";?>
    <!-- Search Results -->
    <div class="container my-4">
        <h1>Search Results For <?php echo $_GET['search'];?> </h1>
        <div class="result">
            <?php 
            $noResult=true;
            $query=$_GET['search'];
            $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title,thread_desc) against('$query')";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
            $noResult=false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];

            echo '<h3><a href="thread.php?threadid='.$thread_id.'" class="text-dark">'.$title.'</a></h3>
            <p>'.$desc.'</p>';
        }
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">Your search - '.$_GET["search"].' - did not match any documents.</h1>
              <p class="lead">Suggestions:</p>
              <ul>
                    <li>Make sure that all words are spelled correctly. </li>
                    <li>Try different keywords.</li>
                    <li>Try more general keywords.</li>
              </ul>
            </div>
          </div>';
        }
            ?>
        </div>
       

    </div>

    <?php include "partials/_footer.php"?>
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