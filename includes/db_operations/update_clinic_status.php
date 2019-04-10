<?php
if(isset($_POST['update_clinicstatus'])) { 

	$patient_id = mysqli_real_escape_string($bd, $_POST['pat_id']);
	$who_stage = mysqli_real_escape_string($bd, $_POST['who_stage']);
	$curr_who_stage = mysqli_real_escape_string($bd, $_POST['curr_who_stage']);
    $curr_who_stage_cond = mysqli_real_escape_string($bd, $_POST['curr_who_stage_cond']);
	$weight = mysqli_real_escape_string($bd, $_POST['weight']);
	$height =  mysqli_real_escape_string($bd, $_POST['height']);
	$art_interrup = mysqli_real_escape_string($bd, $_POST['art_interrup']);
	$h_o_ss_effects = mysqli_real_escape_string($bd, $_POST['pat_id']);
	$ol_6months = mysqli_real_escape_string($bd, $_POST['ol_6months']);
	$sig_diarrhea_vom = mysqli_real_escape_string($bd, $_POST['sig_diarrhea_vom']);
	$alco_drug_consump = mysqli_real_escape_string($bd, $_POST['alco_drug_consump']);
	$trad_med = mysqli_real_escape_string($bd, $_POST['trad_med']);
	$co_medi = mysqli_real_escape_string($bd, $_POST['co_medi']);
	$other_curr_problem = mysqli_real_escape_string($bd, $_POST['other_curr_problem']);
	
	$PeripheralNeuropathy = mysqli_real_escape_string($bd, $_POST['PeripheralNeuropathy']);
	$Jaundice = mysqli_real_escape_string($bd, $_POST['Jaundice']);
	$Lipodystrophy = mysqli_real_escape_string($bd, $_POST['Lipodystrophy']);
	$KidneyFailure = mysqli_real_escape_string($bd, $_POST['KidneyFailure']);
	$Psychosis = mysqli_real_escape_string($bd, $_POST['Psychosis']);
	$Gynecomastia = mysqli_real_escape_string($bd, $_POST['Gynecomastia']);
	$Anemia = mysqli_real_escape_string($bd, $_POST['Anemia']);
	$other = mysqli_real_escape_string($bd, $_POST['sdef_other']);

    $art_interrup_date = '';
    $art_interrup_reason = '';
    // if yes details
	if ($art_interrup == 'intr_Yes') {
		$art_interrup = 'Yes';
        $art_interrup_date = mysqli_real_escape_string($bd, $_POST['art_interrup_date']);
        $art_interrup_reason = mysqli_real_escape_string($bd, $_POST['art_interrup_reason']);
    } else
		$art_interrup = 'No';

	if ($ol_6months == 'Yes'){
		$ol_6months_date = mysqli_real_escape_string($bd, $_POST['ol_6months_date']);
		$ol_6months_dign = mysqli_real_escape_string($bd, $_POST['ol_6months_dign']);
	}

	$sig_diarrhea_vom_details = "";
	$alco_drug_consump_details = "";
	$trad_med_details = "";
	$co_medi_details = "";
	$other_curr_problem_details = "";


	if (isset($_POST['sig_diarrhea_vom_details'])) {
		$sig_diarrhea_vom_details = mysqli_real_escape_string($bd, $_POST['sig_diarrhea_vom_details']);
	}
    
	if (isset($_POST['alco_drug_consump_details'])) {
		$alco_drug_consump_details = mysqli_real_escape_string($bd, $_POST['alco_drug_consump_details']);
	}
    
	if (isset($_POST['trad_med_details'])) {
		$trad_med_details = mysqli_real_escape_string($bd, $_POST['trad_med_details']);
	}
    
	if(isset($_POST['co_medi_details'])) {
		$co_medi_details = mysqli_real_escape_string($bd, $_POST['co_medi_details']);
	}
    
	if(isset($_POST['other_curr_problem_details'])) {
		$other_curr_problem_details = mysqli_real_escape_string($bd, $_POST['other_curr_problem_details']);
	}

    $tables = ["current_clinical_status", "current_clinical_status_details", "patient_side_effects"];
    // first delete
    $sql_delete_ccstatus = "DELETE FROM current_clinical_status where patient_id = $patient_id";
    mysqli_query( $bd,$sql_delete_ccstatus);

    $sql_delete_ccs_details = "DELETE FROM current_clinical_status_details where pat_id = $patient_id";
    mysqli_query( $bd,$sql_delete_ccs_details);

    $sql_delete_patient_seffects = "DELETE FROM patient_side_effects where patient_id = $patient_id";
    mysqli_query( $bd,$sql_delete_patient_seffects);

    // now insert
	$insert_patient = "INSERT INTO current_clinical_status (patient_id,who_stage,curr_who_stage,curr_who_stage_cond,weight,height,art_interrup,h_o_ss_effects, ol_6months, sig_diarrhea_vom, alco_drug_consump, trad_med, co_medi, other_curr_problem)
	VALUES (
	'$patient_id', '$who_stage', '$curr_who_stage', '$curr_who_stage_cond', '$weight', '$height', '$art_interrup', '$h_o_ss_effects', '$ol_6months', '$sig_diarrhea_vom', '$alco_drug_consump', '$trad_med', '$co_medi', '$other_curr_problem' )";
    echo $insert_patients;
	mysqli_query( $bd,$insert_patient);	
    
	$insert_current_clinical_status_details = "INSERT INTO current_clinical_status_details (pat_id,sig_diarrhea_vom_details,alco_drug_consump_details,trad_med_details,co_medi_details, other_curr_problem_details)
	VALUES (
	'$patient_id', '$sig_diarrhea_vom_details', '$alco_drug_consump_details', '$trad_med_details', '$co_medi_details', '$other_curr_problem_details' )";
	mysqli_query( $bd,$insert_current_clinical_status_details);	
 
	$insert_pat_side_effect = "INSERT INTO patient_side_effects (patient_id,PeripheralNeuropathy,Jaundice,Lipodystrophy,KidneyFailure,Psychosis,Gynecomastia,Anemia,other)
	VALUES (
	'$patient_id', '$PeripheralNeuropathy', '$Jaundice', '$Lipodystrophy', '$KidneyFailure', '$Psychosis', '$Gynecomastia','$Anemia','$other')";
    try {
        mysqli_query( $bd, $insert_pat_side_effect);	  
    } catch (Exception $e) {
        throw $e;
    }
    mysqli_query( $bd, "DELETE from art_interruption WHERE patient_id = $patient_id" );
	if ($art_interrup == 'Yes'){
		$insert_art_interruption = "INSERT INTO art_interruption (patient_id,reason,date)
		VALUES (
		'$patient_id', '$art_interrup_reason', '$art_interrup_date')";
		mysqli_query( $bd, $insert_art_interruption);	  
	}

    mysqli_query( $bd,"SELECT * FROM ol_6months_details where patient_id='$patient_id' ");    
	if ($ol_6months == 'Yes'){    
		$insert_ol_6months_details = "INSERT INTO ol_6months_details (patient_id,ol_6months_dign,ol_6months_date)
		VALUES (
		'$patient_id', '$ol_6months_dign', '$ol_6months_date')";
		mysqli_query( $bd, $insert_ol_6months_details);
	}
}

if (isset($_POST['xupdate_clinicstatus'])) {     
	$pat_id = mysqli_real_escape_string($bd, $_POST['pat_id']);
	$art_id_num = mysqli_real_escape_string($bd, $_POST['art_id_num']);
	$firstname = mysqli_real_escape_string($bd, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($bd, $_POST['lastname']);
	$gender = mysqli_real_escape_string($bd, $_POST['gender']);
	$dob = mysqli_real_escape_string($bd, $_POST['dob']);
	$vl_sample_id = mysqli_real_escape_string($bd, $_POST['vl_sample_id']);
	$date_created = date('d/m/Y');

	$sql_update_patient = "UPDATE patient 
		SET art_id_num = '$art_id_num',
		firstname = '$firstname',
		lastname = '$lastname',
		gender = '$gender',
		dob = '$dob',
		vl_sample_id = '$vl_sample_id',
		date_created = '$date_created'       
		WHERE id = '$pat_id'" ;

	$patient_updated = mysqli_query( $bd ,$sql_update_patient);    

	if ($patient_updated) {    
		echo '							 
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Patient details updated</strong>                            
		</div>
		';

		$current_clinical_status=mysqli_query( $bd,"SELECT * FROM current_clinical_status where patient_id='$pat_id' ");
		$if_exist_current_clinical_status = mysqli_num_rows ($current_clinical_status);

		// if ($if_exist_current_clinical_status == '0')
		//	include ('includes/app_clinic_status.php');      
		// else
        echo "Hi!";
        exit();
			include ('includes/app_clinic_status_edit.php');
	} else
		echo "not updated";    
}

?>