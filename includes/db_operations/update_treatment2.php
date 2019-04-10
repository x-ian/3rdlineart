<?php

if(isset($_POST['update_treatment2'])){ 
    $patient_id= mysqli_real_escape_string($bd, $_GET['pat_id']);    
    $sql_delete_treatment2 = "DELETE FROM monitoring where pat_id =$patient_id";    
    // mysqli_query( $bd, $sql_delete_treatment2);	
    if (mysqli_query($bd, $sql_delete_treatment2)) {
    echo '							
<div class="alert alert-success">
                                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                  <strong>CD4 &VL Monitoring updated</strong> 
                           
                           </div>
   ';
    }

    for ($i=1; $i<=10; $i++) {    
        $monito_date = mysqli_real_escape_string($bd, $_POST['monito_date'.$i]);
        $cd4 = mysqli_real_escape_string($bd, $_POST['cd4'.$i]);
        $vl = mysqli_real_escape_string($bd, $_POST['vl'.$i]);
        $reason_4_detectable_vl = mysqli_real_escape_string($bd, $_POST['reason_4_detectable_vl'.$i]); 
        $weight = mysqli_real_escape_string($bd, $_POST['weight'.$i]);

        if ($monito_date !="") {    
            $insert_monitoring=" INSERT INTO monitoring (pat_id,monito_date,cd4,vl,reason_4_detectable_vl,weight)
                                 VALUES (
                                 '$patient_id', '$monito_date', '$cd4', '$vl', '$reason_4_detectable_vl', '$weight')";
            // echo "<br>$insert_monitoring";
            try {                            
                mysqli_query($bd, $insert_monitoring);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->errorMessage() . "\n";
                exit();
            }                       
        }        
    }

/*    
    $monito_date2= mysqli_real_escape_string($bd, $_POST['monito_date2']);
 	$cd42= mysqli_real_escape_string($bd, $_POST['cd42']);
	$vl2=mysqli_real_escape_string($bd, $_POST['vl2']);
	$reason_4_detectable_vl2=mysqli_real_escape_string($bd, $_POST['reason_4_detectable_vl2']); 
	$weight2=mysqli_real_escape_string($bd, $_POST['weight2']); 
    
    $monito_date3= mysqli_real_escape_string($bd, $_POST['monito_date3']);
 	$cd43= mysqli_real_escape_string($bd, $_POST['cd43']);
	$vl3=mysqli_real_escape_string($bd, $_POST['vl3']);
	$reason_4_detectable_vl3=mysqli_real_escape_string($bd, $_POST['reason_4_detectable_vl3']); 
	$weight3=mysqli_real_escape_string($bd, $_POST['weight3']); 
    
    $monito_date4= mysqli_real_escape_string($bd, $_POST['monito_date4']);
 	$cd44= mysqli_real_escape_string($bd, $_POST['cd44']);
	$vl4=mysqli_real_escape_string($bd, $_POST['vl4']);
	$reason_4_detectable_vl4=mysqli_real_escape_string($bd, $_POST['reason_4_detectable_vl4']); 
	$weight4=mysqli_real_escape_string($bd, $_POST['weight4']); 
    
  }
*/
}

?>