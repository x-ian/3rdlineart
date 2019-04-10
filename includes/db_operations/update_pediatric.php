<?php

if(isset($_POST['update_pediatric'])){ 
	
        
    $patient_id= mysqli_real_escape_string($bd, $_POST['pat_id']);
    
    
    $sql_delete_pediatric = "DELETE FROM pediatric where pat_id =$patient_id";
    mysqli_query( $bd,$sql_delete_pediatric);
    
   
    if (mysqli_query($bd, $sql_delete_pediatric)){
    echo '							
<div class="alert alert-success">
                                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                  <strong>Pediatric section updated</strong> 
                           
                           </div>
   ';
    }
    
 	$mother_had_single_dose_NVP= mysqli_real_escape_string($bd, $_POST['mother_had_single_dose_NVP']);
 	$given_NVP= mysqli_real_escape_string($bd, $_POST['given_NVP']);
	$mother_had_PMTCT=mysqli_real_escape_string($bd, $_POST['mother_had_PMTCT']);
	$swallow_tablets=mysqli_real_escape_string($bd, $_POST['swallow_tablets']);
    
    
 	
$insert_pediatric=" INSERT INTO pediatric (pat_id,mother_had_single_dose_NVP,given_NVP,mother_had_PMTCT,swallow_tablets)
VALUES (
'$patient_id', '$mother_had_single_dose_NVP', '$given_NVP', '$mother_had_PMTCT', '$swallow_tablets')";

mysqli_query( $bd,$insert_pediatric);	
    
// include ('includes/app_treatment1_edit.php');   
}

?>