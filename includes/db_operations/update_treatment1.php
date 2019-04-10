<?php

if(isset($_POST['update_treatment1'])){ 
    
    $patient_id= mysqli_real_escape_string($bd, $_GET['pat_id']);
       
    $sql_delete_treatment1 = "DELETE FROM treatment_history where pat_id =$patient_id";
    
    mysqli_query( $bd,$sql_delete_treatment1);
	
    if (mysqli_query($bd, $sql_delete_treatment1)){
    echo '							
<div class="alert alert-success">
                                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                  <strong>ART treatment History updated</strong> 
                           
                           </div>
   ';
    }
    
    for ($i=1; $i<10; $i++) {
        $art_drug1 = mysqli_real_escape_string($bd, $_POST['art_drug'.$i]);
        $art_drug1_b = mysqli_real_escape_string($bd, $_POST['art_drug'.$i.'_b']);
        $art_drug1_c = mysqli_real_escape_string($bd, $_POST['art_drug'.$i.'_c']);
        //end drug row1
        $start_date1 = mysqli_real_escape_string($bd, $_POST['start_date'.$i]);
        $stop_date1 = mysqli_real_escape_string($bd, $_POST['stop_date'.$i]);
        $reason_for_change1 = mysqli_real_escape_string($bd, $_POST['reason_for_change'.$i]);
        $end1 = mysqli_real_escape_string($bd, $_POST['end'.$i]);
        
        // echo "select $i is: \"".$art_drug1.'"';
        if ($art_drug1 != 'select drug' && $art_drug1 != '') {
            
            if ($art_drug1_b != 'select drug'){	
                $art_drug1 .= '-'.$art_drug1_b;  
            } 
            if ($art_drug1_c != 'select drug'){	
                $art_drug1 .= '-'.$art_drug1_c;  
            }
     
            $insert_treatment_history="INSERT INTO treatment_history (pat_id,art_drug,start_date,stop_date,reason_for_change,ended)
VALUES (
'$patient_id', '$art_drug1', '$start_date1', '$stop_date1', '$reason_for_change1', '$end1')";
            mysqli_query($bd, $insert_treatment_history);
        }
    }
}
    
?>