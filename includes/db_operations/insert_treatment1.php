<?php

if(isset($_POST['submit_treatment1'])) { 	
    $patient_id= mysqli_real_escape_string($bd, $_GET['pat_id']);

    for ($i=1; $i<=10; $i++) {
	$art_drug = mysqli_real_escape_string($bd, $_POST['art_drug' . $i]);
	$start_date = mysqli_real_escape_string($bd, $_POST['start_date' . $i]);
	$stop_date=mysqli_real_escape_string($bd, $_POST['stop_date' . $i]);
	$reason_for_change=mysqli_real_escape_string($bd, $_POST['reason_for_change' . $i]);

	if ($art_drug != 'select drug') {	
	    $insert_treatment_history="INSERT INTO treatment_history (pat_id,art_drug,start_date,stop_date,reason_for_change)
	    				VALUES (
					'$patient_id', '$art_drug', '$start_date', '$stop_date', '$reason_for_change')";
	    mysqli_query($bd, $insert_treatment_history);	
	}  
  }
}
?>