<table class="table table-stripwed table-bordedred" border="1">

	<h2 style="background-color:#e5e5e5; text-align:center; color:#000000">Expert Decision on Application</h2> <?php

	global $formID,$num_forms;
	$formID= $_GET['formid'];
	?>             
	<tbody>

<?php
		$form_creation = mysqli_query( $bd,"SELECT * FROM patient, form_creation, expert_review_consolidate2 WHERE  form_creation.3rdlineart_form_id=expert_review_consolidate2.form_id and form_creation.clinician_id ='$clinicianID' and form_creation.patient_id=patient.id and expert_review_consolidate2.form_id ='$formID' ORDER BY `form_creation`.`3rdlineart_form_id` DESC"); 


		$num_forms = mysqli_num_rows ($form_creation);

		while ($row_form_creation = mysqli_fetch_array($form_creation)){

			$_3rdlineart_form_id = $row_form_creation['3rdlineart_form_id'];
			$clinician_id = $row_form_creation['clinician_id'];
			$patient_id = $row_form_creation['patient_id'];
			$pi_mutation = $row_form_creation['pi_mutation'];
			$switch = $row_form_creation['switch'];
			$decision = $row_form_creation['decision'];
			$attachements = $row_form_creation['attachements'];
			$date_reviewed = $row_form_creation['consolidate2_date'];

			$SQL_app_results = "SELECT * FROM app_results WHERE form_id = $_3rdlineart_form_id";
			$app_results = mysqli_query($bd,$SQL_app_results);
			$row_app_results = mysqli_fetch_array($app_results);
			$result_pdf = $row_app_results ['result_pdf'];

			$SQL_clinician = "SELECT * FROM clinician WHERE id = $clinician_id";
			$clinician = mysqli_query($bd,$SQL_clinician);
			$row_clinician = mysqli_fetch_array($clinician);
			$art_clinic = $row_clinician['art_clinic'];

            // echo "<br>ID is $patient_id";
			$patient = new Patient($patient_id);
			$patient_name = $patient->fullname;

			echo '<tr style="width:80%; background-color:#eff80a">
			<th class="td-actions" style="text-align:center"><p style="text-align:center"><a href="#"><strong> 3rdLForm#'.$_3rdlineart_form_id.'</strong></a></p> </th>
			<th class="td-actions" style="text-align:center"><p><strong>'.$patient_name.'</strong></p> </th>
			<th class="td-actions" style="text-align:center"><p><strong>'.$patient->gender.'</strong></p> </th>
			<th class="td-actions" style="text-align:center"><p style="text-align:left"><strong>DOB: '. $patient->dob.'</strong></p>  </th>
		</tr>

	</tbody></table>
	<table class="table table-stripwed table-bordedred" border="1">
		<tbbody>
			<tr>
				<td style="width:80%; background-color:#e2f4f7"> 
					<h2><u>Reviewers Application Decision</u></h2><hr />
					'.$decision.'
				</td>       
				<div class="form-actions">
					<div class="span3" style="float:left">
						<h4><u>Download Attachments</u></h4>
						'.$attachements.'
					</div>
					<div class="span3" style="float:right">
						<a href="documents/results/'.$result_pdf.'" target="_blank" class="btn btn-small btn-primary"> NHLS Patient Result</a>
					</div>
				</div>	
				<hr/>
			</tr> 
			';
		}
	?>
</tbody></table>