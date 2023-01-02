<?php
##DatabaseConnection

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

##Create a connection

$conn = mysqli_connect($servername, $username, $password, $database);

## Die if connection was not successful
if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
     
    <title>iNotes - notes taking made easy</title>
    
  </head>
  <body>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit this note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     
      <form action = "/CRUD/index.php" method = "post">
      <div class="modal-body">
        <input type="hidden" name="snoEdit" id ="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title </label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" rows="5" id="descriptionEdit" name="descriptionEdit"></textarea>
            </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="/CRUD/LOGO.png"  height= "30px" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us </a>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      <?php 
      #insert into database
      if (isset($_GET["delete"])){
        $sno=$_GET['delete'];
        $sql="DELETE FROM `notes` WHERE `Sno`= $sno";
        $result=mysqli_query($conn,$sql);
      
        if($result){
          echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Delete!</strong> Successfully
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }


      }
      if( $_SERVER["REQUEST_METHOD"]=='POST'){
      if (isset($_POST["snoEdit"])){
        $sno = $_POST["snoEdit"];
        $title=$_POST['titleEdit'];
        $description=$_POST["descriptionEdit"];
      
        $sql="UPDATE `notes` SET `title` = '$title',`description` = '$description' WHERE `notes`.`Sno` = $sno";
        $result=mysqli_query($conn,$sql);
      
        if($result){
          echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Updated!</strong> Successfully
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
      }
      else{
        $title=$_POST['title'];
        $description=$_POST["description"];
      
        $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        $result=mysqli_query($conn,$sql);
      
        if($result){
          echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Added!</strong> Successfully
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
      }
    }
      ?>
      <div class="container my-4">
          <h2> Add a Notes </h2>
        <form action = "/CRUD/index.php" method = "post">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title </label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Notes </button>
          </form>
      </div>
     
      <div class="container">
    
<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sno</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
        $sql="SELECT * FROM `notes`";
        $result=mysqli_query($conn,$sql);
        $sno=0;
        while($rows=mysqli_fetch_assoc($result)){
          $sno=$sno+1;
          echo "<tr>
          <th scope='row'> ".$sno. " </th>
          <td> ". $rows['title']. "</td>
          <td>". $rows['description']. "</td>
          <td><button class='edit btn btn-sm btn-primary' id=".$rows['Sno'].">Edit</button>
              <button class='delete btn btn-sm btn-primary' id=d".$rows['Sno'].">Delete</button> 
          </td>
          </tr>";
        }
        ?>  
   
  </tbody>
</table>

      </div>
      <hr>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
     <script>
       $(document).ready( function () {
       $('#myTable').DataTable();
        } );

       
     </script>
     <script>

      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit",);
        tr=e.target.parentNode.parentNode
        title=tr.getElementsByTagName("td")[0].innerText;
        description=tr.getElementsByTagName("td")[1].innerText;
        console.log(title,description)
        descriptionEdit.value=description;
        titleEdit.value=title
        snoEdit.value=e.target.id
        console.log(e.target.id)
        $("#editModal").modal('toggle'); 

        })
        
      });

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit",);
        sno= e.target.id.substr(1,)
        if (confirm("Confirm delete.")){
          console.log("yes")  
          window.location=`index.php?delete=${sno}`;
         }
        else{
          console.log("no")
        }

        })
        
      });



    </script>
  </body>
</html>