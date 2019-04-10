<script type="text/javascript">
     function checkfor3() {
         var nreviewers = $('#edit-profile').find('input[name="checkbox[]"]:checked').length;
         if (nreviewers < 3) {
             alert('Need to select 3 reviewers');
             return false;
         }
         if (nreviewers > 3) {
             alert('Need to select JUST 3 reviewers');
             return false;
         }
         return true;
     }

     function stickyheaddsadaer(obj) {
         if($(obj).is(":checked")){
             // alert("Yes checked"); //when checked
         } else {
             // alert("Not checked"); //when not checked
             if (obj.readOnly == true) {
                 alert("Can't reassign - already reviewed by this reviewer");
                 obj.checked = true;
             }             
         }
     }
</script>
     
<?php
global $formID;
$formID= $_GET['id'];
$reassign = isset($_GET['reassign']);
$lead = $_GET['lead'];


$form_creation=mysqli_query( $bd,"SELECT * FROM form_creation WHERE 3rdlineart_form_id ='$formID'"); 

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

if (!isset($lead)) {
    $app = new Application($formID);
    $lead = $app->lead_reviewer($which='id');
}

echo '<h2 style="background-color:#dedd6;  text-align:center; color:#000000">Assign Reviewers</h2>
<i style="float:right">Please TICK only three (3) <u>Reviewers </u>and Pick one as <u>Lead reviewer</u></i>                 
<form id="edit-profile" class="form-horizontal" action="cp_p1.php?p" method="post">
	<h4 style="color:#69330c; padding:10px; background-color:#deed6;">3rdLineForm#: '. $formID.'</h4>
	<table style="width:100%; background-color:#f7cf75; padding:5px;" >
		<td><p style="color:#000">Name: <strong>'.$patient_name.'</strong>  ART Number: <strong>'.$patient->art_id_num.' </strong> Gender: <strong>'.$patient->gender.'</strong>
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
			<th><h4 style="text-align:center">Reviewer</h4></th>
			<th><h4 style="text-align:center">Currently<br>Assigned</h4></th>
			<th><h4 style="text-align:center">Currently<br>Pending</h4></th>';
            if ($reassign)
			     echo '<th><h4 style="text-align:center">Already<br>Reviewed</h4></th>';
            echo '
			<th><h4 style="text-align:center">Lead Reviewer</h4></th>
		</tr>
	</thead>
	<tbody>
		';

		$reviewer = mysqli_query( $bd,"SELECT * FROM reviewer");
        while ($row_reviewer = mysqli_fetch_array($reviewer)){
			$id = $row_reviewer['id'];           
			$title = $row_reviewer['title'];
			$fname = $row_reviewer['fname'];
			$lname = $row_reviewer['lname'];
			$email = $row_reviewer['email'];
			$phone = $row_reviewer['phone'];
			$rev_fullname = $title.( $title?'. ':''). $fname. ' '. $lname; // ." $id $lead ".(($id == intval($lead)) ? 'checked="checked"' : '');

            if ($reassign) {
                $assigned_this_form = mysqli_query( $bd,"SELECT * FROM assigned_forms where rev_id='$id' and form_id='$formID'");                
                $row_assigned = mysqli_num_rows($assigned_this_form);
                $assigned_checked = ($row_assigned) ? 'checked' : '';

                $lead_checked = ($id == intval($lead)) ? 'checked="checked"' : '';
                $reviewed_this_form = mysqli_query( $bd,"SELECT * FROM expert_review_form where rev_id='$id' and form_id='$formID'");
                $already_reviewed = mysqli_num_rows($reviewed_this_form);
                $reviewed = $already_reviewed ? '<span class="btn btn-success">Yes</span>' : '<span class="btn btn-danger">No</span>';
                // already reviewed, disable
                $assigned_checked .= ($already_reviewed ? ' readonly' : '');
            } 
            $assigned_forms = mysqli_query( $bd,"SELECT * FROM assigned_forms where rev_id='$id'");
			$count = mysqli_num_rows ($assigned_forms);
			$assigned_forms_reviewed = mysqli_query( $bd,"SELECT * FROM assigned_forms where status = 'Reviewed' and rev_id=' $id'");
			$rev_count = mysqli_num_rows ($assigned_forms_reviewed);
			$pending = $count - $rev_count;

			echo '<tr><td>
			<label class="checkbox">
				<input type="checkbox" name="checkbox[]" id="checkbox[]" value="'.$id.'" onchange="stickyheaddsadaer(this);" style="transform:scale(2, 2); margin: 3px;" '.$assigned_checked.'><span style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rev_fullname.'</span></td>
            <td><span style="color:#0b13d0">Assigned<i> ('.$count.')</i></span></td>
            <td><span style="color:#0b13d0">Pending<i> ('.$pending.')</i></span></td>
			</label></td>';
            if ($reassign) {
                echo '<input type="hidden" name="reviewed[]" value="'.$id.'_'.$already_reviewed.'">';
                echo "<td>$reviewed</td>";
            }
            echo '<td><div style="width:110px; float:left" class="radio_btn">
			<input type="radio" class="radio-btn" id="yes_'.$id.'" name="rev_lead" value="'.$id.'" required '.$lead_checked.'>
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
<?php
            if ($reassign)
		        echo '<button type="submit" class="btn btn-primary" style="padding:10px; font-size:180%" name="submit_reviewers" onClick="return checkfor3();">Reassign For Review</button>';
            else
                echo '<button type="submit" class="btn btn-primary" style="padding:10px; font-size:180%" name="submit_reviewers" onClick="return checkfor3();">Submit For Review</button>';
?>
	</div>
</div>

</form>
