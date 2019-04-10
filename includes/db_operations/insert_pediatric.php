<?php

if(isset($_POST['submit_pediatric'])){ 
	
    $patient_id= mysqli_real_escape_string($bd, $_POST['pat_id']);
 	$mother_had_single_dose_NVP= mysqli_real_escape_string($bd, $_POST['mother_had_single_dose_NVP']);
 	$given_NVP= mysqli_real_escape_string($bd, $_POST['given_NVP']);
	$mother_had_PMTCT=mysqli_real_escape_string($bd, $_POST['mother_had_PMTCT']);
	$swallow_tablets=mysqli_real_escape_string($bd, $_POST['swallow_tablets']);
 	
$insert_pediatric=" INSERT  INTO  pediatric (pat_id,mother_had_single_dose_NVP,given_NVP,mother_had_PMTCT,swallow_tablets)
VALUES (
'$patient_id', '$mother_had_single_dose_NVP', '$given_NVP', '$mother_had_PMTCT', '$swallow_tablets')";

mysqli_query( $bd,$insert_pediatric);	
}

?>