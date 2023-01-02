<?php
       $sql1="SELECT * FROM `threads` limit 3";
       $reslt1=mysqli_query($conn,$sql1) or die("Query Failed");
       $rows1=mysqli_fetch_assoc($result1);
       if(mysqli_num_rows($rows1)>0){
           $total_record=mysqli_num_rows($rows1);
           $limit=3;
           $page_number=ceil($total_record/$limit);
           echo '
           <nav aria-label="Page navigation example">
           <ul class="pagination justify-content-end">
             <li class="page-item disabled">
               <a class="page-link" href="#" tabindex="-1">Previous</a>
             </li>';
             for ($i=1; $i <$page_number ; $i++) {
                echo ' <li class="page-item"><a class="page-link" href="threadlist.php?catid='.$id.'&page='.$i.'">{$i}</a></li>';
             }
             echo'
               <a class="page-link" href="#">Next</a>
             </li>
           </ul>
         </nav>';
       }
      
       ?> 