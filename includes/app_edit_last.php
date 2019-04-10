<?php

$adherence_lab=mysqli_query( $bd,"SELECT * FROM adherence where pat_id='$pat_id' ");
        
    $if_exist_adherence_lab = mysqli_num_rows ($adherence_lab);

    if ($if_exist_adherence_lab !='0'){
        
        echo ' 
                                                      <a href=" app.php?back_adherence&pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" class="btn"   style="padding:10px; font-size:180%, margin:5px 0" >Go to Last >> </a>
                                                     ';
    
}

?>