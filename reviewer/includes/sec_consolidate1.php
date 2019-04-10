<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="radio"]').click(function(){
			if($(this).attr("value") == "Yes"){
				$(".box").not(".yes").hide();
                // alert('disable no!');
                $("#comment_no").attr("disabled",true);
				$(".yes").show();
			}
			if($(this).attr("value") == "No"){
				$(".box").not(".no").hide();
                $("#comment_yes").attr("disabled",true);
				$(".no").show();
			}

		});
	});
</script>

<?php
global $formID, $lab;
$formID= $_GET['formid'];
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

echo '<h2 style="background-color:#dedcd6;  text-align:center; color:#000000">Consolidate Expert Reviews</h2>

<form id="edit-profile" class="form-horizontal" action="cp_p1.php?p" method="post">
	<h4 style="color:#69330c; padding:10px; background-color:#deed6;">3rdLineForm#: '. $formID.'</h4>
	<table style="width:100%; background-color:#f7cf75; padding:5px;" >
		<td><p style="color:#000">Name: <strong>'.$patient_name.'</strong>  ART Number: <strong>'.$patient->art_id_num.' </strong> Gender: <strong>'.$patient->gender.'</strong>
			Dob: '.$dob.' </p>
		</td>
		<td>
			<p style="color:#000">Facility: <strong>'.$patient->art_clinic.'</strong> Clinician: <strong>'.$clinician_name.'</strong> </p>
		</td>
	</tr>
</table>
<hr />  
';
echo '<form id="edit-profile" class="form-horizontal" action="cp_p1.php?p" method="post" style=" padding:10px;">';

?>

<?php
$expert_review_form=mysqli_query( $bd,"SELECT * FROM expert_review_form where form_id ='$formID' ");
$comments = '';
$reviewer_names = '';
while ($row_expert_review_form=mysqli_fetch_array($expert_review_form)){

	$rev_id = $row_expert_review_form['rev_id'];
	$genotyping = $row_expert_review_form['genotyping'];
	$comment_to_clinician = $row_expert_review_form['comment_to_clinician'];
	$date_reviewed = $row_expert_review_form['date_reviewed'];

	$select_reviewer = mysqli_query( $bd,"SELECT * FROM reviewer where id='$rev_id'"); 
	$row_select_reviewer = mysqli_fetch_array($select_reviewer);

	$rev_fname = $row_select_reviewer['fname']; 
	$rev_lname = $row_select_reviewer['lname']; 
	$rev_title = $row_select_reviewer['title']; 

	$rev_fullname = $rev_title.'.  '.$rev_fname.' '.$rev_lname;
    $reviewer_names .= ($reviewer_names ? ', ' : '').$rev_fullname;
	$comments .= ' 
	<table class="table table-striped table-bordered" title="Reviewer 1">
		<th><h4>Reviewer : <strong><u> '.$rev_fullname.'</u></strong></h4></th>
		<tr><td><p>Genotyping: '.$genotyping.'</p>
			<h4>Comment</h4>
			<p>
				'.$comment_to_clinician.'
			</p>
		</td></tr>
	</table>
	';
}
echo $comments;

$form_creation=mysqli_query( $bd,"SELECT clinician_id FROM form_creation where 3rdlineart_form_id ='$formID' "); 

while ($row_form_creation=mysqli_fetch_array($form_creation)){
	$clinician_id =$row_form_creation['clinician_id'];
	$SQL_clinician = "SELECT * FROM clinician WHERE id=$clinician_id";
	$clinician = mysqli_query($bd,$SQL_clinician);

	$row_clinician = mysqli_fetch_array($clinician);
	$clinician_name = $row_clinician['name'];
	$clinician_phone = $row_clinician['phone'];
	$clinician_email = $row_clinician['email'];
	$art_clinic = $row_clinician['art_clinic'];
}
// echo "<br>clinician_email is $clinician_email";
?>

<!-- </tr></tbody></table>-->
</form>

<form id="edit-profile" class="form-horizontal" action="review_p1.php?lead_reviewer" method="post" style="background-color:#dedcd6; padding:20px">

	<h2 style="background-color:#f5ec10; text-align:center">Fabricated Information</h2>
	<hr style=" border: 1.5px solid #b49308;" />

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('input[name="art_interrup"]').on('click', function () {
				if ($(this).val() === 'Yes') {
					$('#datepicker,#art_interupt_reason').prop("disabled", false);
				} else {
					$('#datepicker,#art_interupt_reason').prop("disabled", "disabled");
				}
			});
		});
	</script>  

	<script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "textarea",
			theme: "modern",
			plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview | forecolor backcolor emoticons",
			image_advtab: true,
			templates: [
			{title: 'Test template 1', content: 'Test 1'},
			{title: 'Test template 2', content: 'Test 2'}
			]
		});
	</script>

	<tr>
		<td>
			<h4>Is Genotyping indicated?</h4>          
		</td>
		<td>
			<input type="hidden" name="clinician_email" value="<?php echo $clinician_email; ?>" />
			<input type="hidden" name="clinician_name" value="<?php echo $clinician_name; ?>" />
            <input type="hidden" name="reviewer_names" value="<?php echo $reviewer_names; ?>" />
			<input type="hidden" name="formid" value="<?php echo $formID; ?>" />

			<div style="width:110px; float:left" class="radio_sty">
				<input type="radio" id="genotyping" name="genotyping" value="Yes"  required>
				<label for="genotyping">Yes</label>

				<div class="check">
				</div>
			</div>
			<div style="width:100px; float:left" class="radio_sty">
				<input type="radio" id="ngenotyping" name="genotyping" value="No" >
				<label for="ngenotyping">No</label>

				<div class="check">
				</div>
			</div>
		</td>   
	</tr>
	<tr><td><br /><br /></td></tr>
	<tr>
		<td>

		</td>
		<div class="yes box">
			<td><h2>Genotyping Indicated</h2>
				<h4>Comment to Clinician?</h4>

				<textarea type="text" class="span4" rows="8" name="comment_to_clinician" id="comment_yes" >
					<p>Dear&nbsp; <?php echo $clinician_name; ?></p>
					<p>Thank you for the application for resistance testing for your patient (Form #<?php echo $formID; ?>).</p>
					<p>Your Application was reviewed and the committee suggests that resistance testing is indicated.</p>
					<p>Please take a DBS sample for the patient, call and send to:<br><?php echo $lab->details(); ?></p>
					<p>&nbsp;</p>
					<p>Thank you very much,</p>
					<p>Regards</p>
					<p>&nbsp;</p>  
					<p><?php echo $loginfullname; ?></p>  
					<p>3rd Line committee team lead expert reviewer</p>                                     
				</textarea>

				<p> Sending to: <u><?php echo $clinician_name; ?> </u>     Clinician at: <u><?php echo $art_clinic; ?> </u></p>
			</td>  
		</div>
		<div class="no box">
			<td>
				<h2>Genotyping <U style="color:#f00">NOT</U> Indicated</h2>
				<h4>Comment to Clinician?</h4>

				<textarea type="text" class="span4" rows="8" name="comment_to_clinician" id="comment_no" >
					<p>Dear&nbsp; <?php echo $clinician_name; ?></p>
					<p>&nbsp;</p>
					<p>Thank you for the application for resistance testing for your patient (Form #<?php echo $formID; ?> ).</p>
					<p>&nbsp;</p>
					<p>Your Application was reviewed and the committee suggests that resistance testing is <U style="color:#f00">NOT</U> indicated.</p>
					<p>&nbsp;</p>
					<p>Please see the feedback below:</p>
                    <?=$comments?>				
					<p>&nbsp;</p>
					<p>Thank you very much,</p>
					<p>Regards</p>
					<p>&nbsp;</p>
					<p><?php echo $fullname; ?></p>  
					<p>3rd Line committee secretary</p>                                     
				</textarea>
                    
				<p> Sending to: <u><?php echo $clinician_name; ?> </u> Clinician at: <u><?php echo $art_clinic; ?> </u></p>
			</td>  
		</div>
	</tr>
</table>
</td>    
</tr> 

<div class="form-actions">
	<div class="span3">
		<button class="btn" style="padding:10px; font-size:180%"><a href="review_p1.php?lead_reviewer">Cancel</a></button>
	</div>
	<div class="span3"></div>
	<div class="span3">
		<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_consolidate1">Send</button> 
	</div>
</div>
</form>