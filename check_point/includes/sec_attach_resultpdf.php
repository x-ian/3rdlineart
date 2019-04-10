<?php
include ('includes/insert_attach_result.php');  

global $formID;
$formID= $_GET['id'];

echo '
<h2 style="background-color:#8985f0; text-align:center; color:#fff">Application Results from NHLS</h2>
<hr style=" border: 1px solid #cbe509;" />
<form id="edit-profile" class="form-horizontal" action="cp_p1.php?received&id='.$formID.'" method="post" style="background-color:#fdfdfd; padding:20px;" enctype="multipart/form-data" >';

echo '
<div class="form-actions">  
	<h3 style="color:#689d04"><span>Attach Result : </span><input type="file" name="file" value="Attach Result" required /></h3>                
</div>
';

$form_creation=mysqli_query( $bd,"SELECT * FROM form_creation where 3rdlineart_form_id ='$formID'"); 

	while ($row_form_creation=mysqli_fetch_array($form_creation)){
		$clinician_id =$row_form_creation['clinician_id'];
		$patient_id =$row_form_creation['patient_id'];
        
		$SQL_clinician = "SELECT * FROM clinician WHERE id=$clinician_id";
		$clinician = mysqli_query($bd,$SQL_clinician);
		$row_clinician = mysqli_fetch_array($clinician);
		$art_clinic = $row_clinician['art_clinic'];
		$clinician_name = $row_clinician['name'];

        $patient = new Patient($patient_id);
        $patient_name = $patient->fullname;        
	}

	echo '<h2 style="background-color:#dedd6;  text-align:center; color:#000000">Assign Reviewers</h2>
	<i style="float:right">Please TICK only <u>three reviewers </u>and Pick one as <u>Lead reviewer</u></i>                 
	<!-- <form id="edit-profile" class="form-horizontal" action="cp_p1.php?p" method="post"> -->
		<h4 style="color:#69330c; padding:10px; background-color:#deed6;">3rdLineForm#: '. $formID.'</h4>
		<table style="width:100%; background-color:#f7cf75; padding:5px;" >
			<td><p style="color:#000">Name: <strong>'.$patient_name.'</strong>   ART Number: <strong>'.$patient->art_id_num.' </strong> Gender: <strong>'.$patient->gender.'</strong>
				Dob: '.$patient->dob.' </p>
			</td>
			<td>
				<p style="color:#000">Facility: <strong>'.$patient->art_clinic.'</strong> Clinician: <strong>'.$clinician_name.'</strong> </p>
			</td>
		</tr>
	</table>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <h4 style="text-align:center">Reviewer</h4> </th>
				<th><h4 style="text-align:center">Lead Reviewer </h4></th>
			</tr>
		</thead>
		<tbody>
			';

			$reviewer=mysqli_query( $bd,"SELECT * FROM reviewer"); 
			while ($row_reviewer=mysqli_fetch_array($reviewer)){

				$id =$row_reviewer['id'];
				$title =$row_reviewer['title'];
				$fname =$row_reviewer['fname'];
				$lname =$row_reviewer['lname'];
				$email =$row_reviewer['email'];
				$phone =$row_reviewer['phone'];
				$rev_fullname =$title.'. '. $fname. ' '. $lname;
                
				$assigned_forms=mysqli_query( $bd,"SELECT * FROM assigned_app_results where rev_id=' $id'");
				$count = mysqli_num_rows ($assigned_forms);
				$assigned_forms_reviewed=mysqli_query( $bd,"SELECT * FROM assigned_app_results where status = 'Reviewed' and rev_id=' $id'");
				$rev_count = mysqli_num_rows ($assigned_forms_reviewed);
				$pending = $count - $rev_count;

				echo '<tr><td>
				<label class="checkbox ">
					<input type="checkbox" name="checkbox[]" id="checkbox[]" value="'.$id.'" style="transform:scale(2, 2); margin: 3px;" ><p>&nbsp&nbsp'.$rev_fullname.'</p> <span style="color:#0b13d0">Assig <i>('.$count.')</i> Pending <i>('.$pending.')</i></span>
				</label></td><td><div style="width:110px; float:left" class="radio_sty">
				<input type="radio" id="yes_'.$id.'" name="rev_lead" value="'.$id.'" required>
				<label for="yes_'.$id.'">Yes</label>

				<div class="check">
				</div>
			</div>
		</div></td></tr>';
	}
?>

</tbody></table>
<input type="hidden" name="formID" value="<?php echo $formID; ?>" /> 

<div class="form-actions">
	<div class="span4">
		<button class="btn" style="padding:10px; font-size:180%"><a href="cp_p1.php?p">Cancel</a></button>
	</div>
	<div class="span3">
		<button type="submit" class="btn btn-primary" style="padding:10px; font-size:180%" name="submit_assign_result">Submit For Review</button> 
	</div>
</div>
			
</form>