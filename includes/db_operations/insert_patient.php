<?php
global $gender;
if(isset($_POST['submit_patD'])) {
    // echo "<br>insert patient";
    // encrypt the important identifiers
    // $pat_art_clinic = encrypt(mysqli_real_escape_string($bd, $_POST['pat_art_clinic']), $enckey);
	$art_id_num = encrypt(mysqli_real_escape_string($bd, $_POST['art_id_num_facility']).'-'. mysqli_real_escape_string($bd, $_POST['art_id_num']), $enckey);
    $art_id_num_facility = encrypt(mysqli_real_escape_string($bd, $_POST['art_id_num_facility']), $enckey);
    $art_id_num_ref = encrypt(mysqli_real_escape_string($bd, $_POST['art_id_num_ref']), $enckey);
    
    // combine
	$firstname = encrypt(mysqli_real_escape_string($bd, $_POST['firstname']), $enckey);
	$lastname = encrypt(mysqli_real_escape_string($bd, $_POST['lastname']), $enckey);

	$gender = mysqli_real_escape_string($bd, $_POST['gender']);
	$dob = mysqli_real_escape_string($bd, $_POST['dob']);
    // echo "<br>dob=$dob";
	$vl_sample_id = mysqli_real_escape_string($bd, $_POST['vl_sample_id']);
	$date_created = date('d/m/Y');

	$check_patient = mysqli_query( $bd,"SELECT * FROM patient where art_id_num='$art_id_num' "); 
	$patient_exists = mysqli_num_rows ($check_patient);
    // echo  "<br>exists: $patient_Exist";

	if ($patient_exists == '0') {
        // echo $_POST['pat_art_clinic']."'inserting '$pat_art_clinic','$art_id_num', '$firstname', '$lastname', '$gender'";
		$insert_patient = "INSERT INTO patient(pat_art_clinic, art_id_num, firstname, lastname, gender, dob, vl_sample_id, date_created, art_id_num_ref)
		VALUES (
		'$art_id_num_facility','$art_id_num', '$firstname', '$lastname', '$gender', '$dob', '$vl_sample_id', '$date_created', '$art_id_num_ref' )";
        // echo "<br>$insert_patient";
		mysqli_query( $bd,$insert_patient);	
		$pat_id = mysqli_insert_id( $bd);
        
        // creating form identifier 
        $insert_form_creation = "INSERT INTO form_creation (clinician_id, patient_id, status, date_created)
   	VALUES (
   	'$clinicianID', '$pat_id', 'Not Complete', '$date_created' )";
   	mysqli_query( $bd,$insert_form_creation);
    // echo "<br>$insert_form_creation";   	
    } else {
        echo '
   	<div class="alert alert-block">
   		<button type="button" class="close" data-dismiss="alert">&times;</button>
   		<h4>Failed!!</h4>
   		Patient with ART number already exist.
   	</div> ';
        echo "<meta http-equiv=\"Refresh\" content=\"2; url=app.php?return_part_1\">";
    }
}

?>