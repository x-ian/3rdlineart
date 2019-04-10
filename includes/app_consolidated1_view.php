
<h2 style="background-color:#e5e5e5; text-align:center; color:#000000">Application with Decision</h2>
<?php
global $formID,$num_forms;
$formID= $_GET['formid'];
?>     
<tbody>

<?php
// echo "<br>app_consolidated1_view";
$form_creation=mysqli_query( $bd,"SELECT * FROM patient, form_creation, expert_review_consolidate1 WHERE  form_creation.3rdlineart_form_id=expert_review_consolidate1.form_id and form_creation.clinician_id ='$clinicianID' and form_creation.patient_id=patient.id and expert_review_consolidate1.form_id ='$formID' ORDER BY `form_creation`.`3rdlineart_form_id` DESC"); 
$num_forms = mysqli_num_rows ($form_creation);

	while ($row_form_creation=mysqli_fetch_array($form_creation)){

		$_3rdlineart_form_id = $row_form_creation['3rdlineart_form_id'];
		$clinician_id = $row_form_creation['clinician_id'];
		$patient_id = $row_form_creation['patient_id'];
		$genotyping = $row_form_creation['genotyping'];
		$comment_to_clinician = $row_form_creation['comment_to_clinician'];
		$date_reviewed = $row_form_creation['date_reviewed'];

		$SQL_clinician = "SELECT * FROM clinician WHERE id=$clinician_id";
		$clinician = mysqli_query($bd,$SQL_clinician);
		$row_clinician = mysqli_fetch_array($clinician);
		$art_clinic = $row_clinician['art_clinic'];
		
		$patient = new Patient($patient_id);
		$patient_name = $patient->fullname;

		echo '    
		<h4 style="color:#69330c; padding:10px; background-color:#deed6;">3rdLineForm#: '. $formID.'</h4>
		<table style="width:100%; background-color:#f7cf75; padding:5px;" >
			<td><p style="color:#000">Name: <strong>'.$patient_name.'</strong>   ART Number: <strong>'.$patient->art_id_num.' </strong> Gender: <strong>'.$patient->gender.'</strong>
				Dob: '.$patient->dob.' </p>
			</td>
			<td>'; 
        if ($genotyping == 'Yes' and !isset($_GET['sample_already_requested'])){
					echo '
					<a href="app.php?p&sendsample&formid='. $_3rdlineart_form_id.'" style="float:right" class="btn btn-large btn-primary"><i class="btn-icon-only icon-ok"> Dispatch Sample </i></a>';
				}

				echo '
			</td>
		</tr>
	</table>
	<hr />  

	<table>
		<tbbody>
			<tr>
				<td style="width:80%; padding:20px"> 
					<h4><u>Application Decision</u></h2><hr />
						'. $comment_to_clinician.'
					</td>
					<td class="td-actions"
					</td>
				</tr> 
				';
			}
			?>
		</tbody></table>