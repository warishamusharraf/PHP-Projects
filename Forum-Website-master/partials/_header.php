<?php
session_start();
echo'    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum/">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum/">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php" tableindex="-1">Contact</a>
      </li>
    </ul>';
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
      echo ' <form class="d-flex"  method="get" action="search.php" >
      <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
    </form>
    <a class="btn btn-outline-success mx-2" href="partials/_logout.php">LogOut</a>';
    }
    else{
    echo '<form class="d-flex" method="get" action="search.php" >
      <input class="form-control me-2" name="search" "type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
    </form>
    <div class="mx-2">
        <button class="btn btn-outline-success"data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-success"data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>

      </div>';
    }
      echo'
  </div>
</div>
</nav>';

include "partials/login_modal.php";

include "partials/signup_modal.php";
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Account SignUp!</strong> Thanks for connect with us Now You can Login.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="true"){
  echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
  <strong>Successfully </strong> Account Login !
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

if(isset($_GET['loginsuccess']) && $_GET['loginsuccess']=="false"){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Error! </strong> Account Can Not Login You Should Sign Up
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false"){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Error! </strong> Email Already in Use Try Another
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}



?>