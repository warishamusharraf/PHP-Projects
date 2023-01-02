<?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true){
         echo '   <div class="container">
         <h1>Post a Comments</h1>
         <form action="'. $_SERVER['REQUEST_URI'].'" method="post">
             <div class="form-group">
                 <label for="desc">Type your Comments</label>
                 <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                 <input type="hidden" name="sno" value="'. $_SESSION['sno'].'">
             </div>

             <button type="submit" class="btn btn-success">post comments</button>
         </form>



     </div>';
    }
    else{
        echo'
        <div class="container">
        <p class="lead">You are not Logged in Please Login Your Account For Post a Comment</p>
        
        
        </div>';
        }
    ?>