<?php

if(isset($_POST['submit_Preg'])){ 
	
    $patient_id= mysqli_real_escape_string($bd, $_POST['pat_id']);
 	$pregnant= mysqli_real_escape_string($bd, $_POST['pregnant']);
 	$weeks_o_preg= mysqli_real_escape_string($bd, $_POST['weeks_o_preg']);
	$breastfeeding=mysqli_real_escape_string($bd, $_POST['breastfeeding']);
    
    if ($pregnant=='Yes_preg'){
    $pregnant ='Yes';
    }
    if ($pregnant=='No_preg'){
    $pregnant ='No';
    }
 	
$insert_preg=" INSERT  INTO  pregnancy (pat_id,pregnant,weeks_o_preg,breastfeeding)
VALUES (
'$patient_id', '$pregnant', '$weeks_o_preg', '$breastfeeding')";

mysqli_query( $bd,$insert_preg);	
}

?>