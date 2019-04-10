<?php

if (isset($_POST['submit_treatment2'])) { 
	
    $patient_id= mysqli_real_escape_string($bd, $_GET['pat_id']);
        
    for ($i=1; $i<=10; $i++) {
        $monito_date = mysqli_real_escape_string($bd, $_POST['monito_date'.$i]);
        $cd4 = mysqli_real_escape_string($bd, $_POST['cd4'.$i]);
        $vl = mysqli_real_escape_string($bd, $_POST['vl'.$i]);
        $reason_4_detectable_vl = mysqli_real_escape_string($bd, $_POST['reason_4_detectable_vl'.$i]); 
        $weight = mysqli_real_escape_string($bd, $_POST['weight'.$i]); 

        if ($monito_date != "") {    
            $insert_monitoring="INSERT INTO monitoring (pat_id,monito_date,cd4,vl,reason_4_detectable_vl,weight)
            VALUES (
            '$patient_id', '$monito_date', '$cd4', '$vl', '$reason_4_detectable_vl', '$weight')";
            mysqli_query($bd, $insert_monitoring);	
        }
    }
}

?>