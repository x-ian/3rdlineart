<?php
// echo 'patient_id is: '.$pat_id;
$patient_table=mysqli_query( $bd,"SELECT id FROM patient where id='$pat_id' ");
$if_exist_patient_table = mysqli_num_rows ($patient_table);
// echo 'table exists: '.$if_exist_patient_table;

echo '<a href="#myModal" role="button" data-toggle="modal" style="padding:6px; font-size:110%; position:relative; left:-20px; top:5px;" >Edit Menu</a>
<div id="myModal" class="modal fade" style="height: 500px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h2 style="text-align:center">Edit Menu</h2>
	</div>
<div class="modal-body">';

if ($if_exist_patient_table != '0') {			   
    echo '<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >				
				<a href="app.php?back&part_1&pat_id='.$pat_id.'" class="btn btn-warning" style="width:90%;" >Patient Details</a>
		  </div>';
}

$current_clinical_status=mysqli_query( $bd,"SELECT * FROM current_clinical_status where patient_id='$pat_id' ");
$if_exist_current_clinical_status = mysqli_num_rows ($current_clinical_status);
if ($if_exist_current_clinical_status !='0'){			
    echo '<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
			<a href="app.php?back&part_2&app_clin&pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" class="btn btn-warning" style="width:90%;" >Current Clinic status</a>
		</div>';		
}

$pediatric_section=mysqli_query( $bd,"SELECT * FROM pediatric where pat_id='$pat_id' ");
$if_exist_pediatric_section = mysqli_num_rows ($pediatric_section);
	if ($if_exist_pediatric_section !='0' && $age < 4 ){		
		echo ' <div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
		<a href="app.php?back&back_3&back_treatment1&pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" class="btn btn-warning" style="width:90%;" >Pediatric Section</a>
	</div>';	
}

$pregnancy=mysqli_query( $bd,"SELECT * FROM pregnancy where pat_id='$pat_id' ");
$if_exist_pregnancy = mysqli_num_rows ($pregnancy);
if ($if_exist_pregnancy !='0' || $age > 10 && $gender=='Female'){
	echo ' <div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
	<a href="app.php?back&back_3&back_treatment1&pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" class="btn btn-warning" style="width:90%;" >Pregnancy Section</a>
</div>';
}

$treatment_history=mysqli_query( $bd,"SELECT * FROM treatment_history where pat_id='$pat_id' ");
$if_exist_treatment_history = mysqli_num_rows ($treatment_history);
if ($if_exist_treatment_history != '0'){
	echo ' <div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
	<a href="app.php?back&back_treatment2&pat_id='.$pat_id.'" class="btn btn-warning" style="width:90%;" >ART Treatment</a>
</div>';

}

$treatment_monitoring=mysqli_query( $bd,"SELECT * FROM monitoring where pat_id='$pat_id' ");
$if_exist_treatment_monitoring = mysqli_num_rows ($treatment_monitoring);
if ($if_exist_treatment_monitoring != '0') {
	echo '<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
	<a href="app.php?back&back_treatment3&pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" class="btn btn-warning" style="width:90%;" >CD4 & VL Monitoring</a>
</div>';

}

$tb_treat=mysqli_query( $bd,"SELECT * FROM tb_treat where pat_id='$pat_id' ");
$if_exist_tb_treat = mysqli_num_rows ($tb_treat);
if ($if_exist_tb_treat != '0') {
	echo '<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
	<a href="app.php?back&back_adherence&pat_id='.$pat_id.'" class="btn btn-warning" style="width:90%;" >TB Treatment</a>
</div>';
}

$adherence_lab=mysqli_query( $bd,"SELECT * FROM adherence where pat_id='$pat_id' ");
$if_exist_adherence_lab = mysqli_num_rows ($adherence_lab);
if ($if_exist_adherence_lab != '0') {	
	echo '<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
	<a href="app.php?back_complete&pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" class="btn btn-warning" style="width:90%;" >ART Adherence & Lab</a>
</div>';
	echo ' <div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
	<a href="complete_form.php?pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" class="btn btn-warning" style="width:90%;" >Review Form</a>
</div>';
}

echo '
</div>
<div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
</div>
</div>
';
?>