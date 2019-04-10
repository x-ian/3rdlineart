<?php
global $enckey;
// echo "<br>inside update_patient: key is $enckey";
// foreach($_POST as $key => $value) { echo "<br>$key: $value"; }
// exit();

if(isset($_POST['update_patD'])) {
    $pat_art_clinic = encrypt(mysqli_real_escape_string($bd, $_POST['pat_art_clinic']), $enckey);
    // echo "<br>".$_POST['pat_art_clinic'].", pat_art_clinic is ".$pat_art_clinic;
    $pat_id = mysqli_real_escape_string($bd, $_POST['pat_id']);
    // $art_id_num = encrypt(mysqli_real_escape_string($bd, $_POST['art_id_num']), $enckey);
    // combine here!!!
    $art_id_num = encrypt(mysqli_real_escape_string($bd, $_POST['art_id_num_facility']).'-'. mysqli_real_escape_string($bd, $_POST['art_id_num']), $enckey);
    $art_id_num_facility = encrypt(mysqli_real_escape_string($bd, $_POST['art_id_num_facility']), $enckey);
    $art_id_num_ref = encrypt(mysqli_real_escape_string($bd, $_POST['art_id_num_ref']), $enckey);
    // echo "<br>".$_POST['art_id_num_facility'].", art_id_num facility is ".$art_id_num_facility;
 	$firstname = encrypt(mysqli_real_escape_string($bd, $_POST['firstname']), $enckey);
    $lastname = encrypt(mysqli_real_escape_string($bd, $_POST['lastname']), $enckey);
 	$gender = mysqli_real_escape_string($bd, $_POST['gender']);
	$dob = mysqli_real_escape_string($bd, $_POST['dob']);
    // echo "<br>dob=$dob";
    
	$vl_sample_id = mysqli_real_escape_string($bd, $_POST['vl_sample_id']);
	$date_created = date('d/m/Y');
    
    $sql_update_patient = "UPDATE patient 
      SET art_id_num = '$art_id_num',
       art_id_num_ref = '$art_id_num_ref',
       pat_art_clinic = '$art_id_num_facility',
       firstname = '$firstname',
       lastname = '$lastname',
       gender = '$gender',
       dob = '$dob',
       vl_sample_id = '$vl_sample_id',
       date_created = '$date_created',
       enc = 1
       WHERE id = '$pat_id'" ;

    // echo $sql_update_patient;
    $patient_updated = mysqli_query( $bd ,$sql_update_patient);    
    
    if ($patient_updated) {
        echo '<div class="alert alert-success">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>Patient details updated</strong>             
          </div>';
   
        $current_clinical_status=mysqli_query( $bd,"SELECT * FROM current_clinical_status where patient_id='$pat_id' ");
        $if_exist_current_clinical_status = mysqli_num_rows ($current_clinical_status);

        if (0) { // $role != 'Admin') {
            if ($if_exist_current_clinical_status == '0') {
                echo "<meta http-equiv=\"Refresh\" content=\"0; url=app.php?app_clin&pat_id=".$pat_id."\">";    
            } else {
                include ('includes/app_clinic_status_edit.php');     
            }
        }
    } else {
        echo "not updated";    
    }
}
?>