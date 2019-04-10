<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="radio"]').click(function(){
			if($(this).attr("value")=="Yes"){
				$(".box").not(".yes").hide();
				$(".yes").show();
			}
			if($(this).attr("value")=="No"){
				$(".box").not(".no").hide();
				$(".no").show();
			}
		});
	});
</script>
<?php
global $formID;
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

echo '<h2 style="background-color:#dedd6;  text-align:center; color:#000000">Consolidate Expert Reviews</h2>

<form id="edit-profile" class="form-horizontal" action="cp_p1.php?p" method="post">
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
<hr />  
';

echo '<form id="edit-profile" class="form-horizontal" action="cp_p1.php?pending" method="post" style="background-color:#ddf; padding:10px;">';
?>
<tr>
	<?php
	$expert_review_result=mysqli_query( $bd,"SELECT * FROM expert_review_result where form_id ='$formID' "); 

	while ($row_expert_review_result=mysqli_fetch_array($expert_review_result)){
		$rev_id = $row_expert_review_result['rev_id'];
		$pi_mutation =$row_expert_review_result['pi_mutation'];
		$switch =$row_expert_review_result['switch'];
		$drug1=$row_expert_review_result['drug1'];
		$drug2=$row_expert_review_result['drug2'];
		$drug3=$row_expert_review_result['drug3'];
		$drug4=$row_expert_review_result['drug4'];
		$drug5=$row_expert_review_result['drug5'];
		$comment =$row_expert_review_result['comment'];
		$feedback_to_clinician =$row_expert_review_result['feedback_to_clinician'];

		$select_reviewer=mysqli_query( $bd,"SELECT * FROM reviewer where id='$rev_id'"); 
		$row_select_reviewer=mysqli_fetch_array($select_reviewer);

		$rev_fname =$row_select_reviewer['fname']; 
		$rev_lname =$row_select_reviewer['lname']; 
		$rev_title =$row_select_reviewer['title']; 

		$rev_fullname = $rev_title.'.  '.$rev_fname.' '.$rev_lname;

		echo ' 
		<table class="table table-striped table-bordered" title="Reviewer 1">
			<th><h4>Reviewer : <strong><u> '.$rev_fullname.'</u></strong></h4></th>
			<tr><td>
				<p>PI Mutation present: '.$pi_mutation.'</p>
				<p>Switch: '.$switch.'</p>';
				if ($switch=='Yes'){
					echo '<table border="1">
					<thead>
						<tr>
							<th class="td-actions" style="text-align: center;">&nbsp;</th>
							<th class="td-actions" style="text-align: center;">
								<p><strong>Drug Name</strong></p>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Drug 1:</td>
							<td>'.$drug1.'</td>
						</tr>
						<tr>
							<td>Drug 2:</td>
							<td>'.$drug2.'</td>
						</tr>
						<tr>
							<td>Drug 3:</td>
							<td>'.$drug3.'</td>
						</tr>
						<tr>
							<td>Drug 4:</td>
							<td>'.$drug4.'</td>
						</tr>
						<tr>
							<td>Drug 5:</td>
							<td>'.$drug5.'</td>
						</tr>
					</tbody>
				</table>
				<p><strong><u>Comment (optional): </u></strong></p>
				<p>
					'. $comment.'
				</p>';
			}

			else {
				echo  '<p><strong><u>Feedback to Clinician: </u></strong></p>
				<p>'.$feedback_to_clinician.'</p>
				';
			}
			echo '
		</td>';
	}
	echo '
</td></tr>
</table>
';

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
?>

</tr></tbody></table>

</form>
<hr /><br />
<form id="edit-profile" class="form-horizontal" action="cp_p1.php?pending" method="post" style="background-color:#ccc; padding:20px">

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
			<h4>Is PI mutation present?</h4> 
			<div class="controls" style="position:relative; left:-150px">
				<label class="radio inline">
					<input type="radio"  name="pi_mutation" value="Yes_pi" id="app_radio" required> Yes
				</label>

				<label class="radio inline">
					<input type="radio" name="pi_mutation" value="No_pi" id="app_radio"> No
				</label>
			</div>	<!-- /controls -->  <br />

			<h4>Is Switch indicated?</h4>  
			<div class="controls" style="position:relative; left:-150px">
				<label class="radio inline">
					<input type="radio"  name="switch" value="Yes" id="app_radio" required> Yes
				</label>

				<label class="radio inline">
					<input type="radio" name="switch" value="No" id="app_radio"> No
				</label>
			</div>	<!-- /controls -->	
		</td>
		<td>
			<input type="hidden" name="clinician_email" value="<?php echo $clinician_email; ?>" />
			<input type="hidden" name="clinician_name" value="<?php echo $clinician_name; ?>" />
			<input type="hidden" name="formid" value="<?php echo $formID; ?>" />
		</td>   
	</tr>
	<tr>
		<td>

		</td>
		<div class="yes box">
			<td><h2>Switch Indicated</h2>
				<h4>Comment to Clinician?</h4>

				<textarea type="text" class="span4" rows="8" name="decision"  id="area1" >
					<p>Dear&nbsp; <?php echo $clinician_name; ?></p>

					<p>&nbsp;</p>
					<p>Thank you for the application for resistance testing for your patient.</p>
					<p>&nbsp;</p>
					<p>We received your patient&rsquo;s resistance test results (attached). From the resistance mutations of your patient, the 3<sup>rd</sup> line committee concluded that switch of ART is indicated.</p>
					<p>The committee recommends the following ART regimen:</p>
					<table>
						<thead>
							<tr>
								<th class="td-actions" style="text-align: center;">&nbsp;</th>
								<th class="td-actions" style="text-align: center;">
									<p><strong>Drug Name</strong></p>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Drug 1:</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Drug 2:</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Drug 3:</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Drug 4:</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>Drug 5:</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<p>&nbsp;</p>
					<p>Comment from reviewers:</p>
					<p>&nbsp;</p>
					<p>You will receive the drugs from the DHA within the next weeks. If you have any problems receiving the 3<sup>rd</sup> line drugs, please contact Supply chain at DHA.</p>
					<p>Contact person:</p>
					<p>Tel Number:</p>
					<p>Email:</p>
					<p>&nbsp;</p>
					<p>Please find attached information for you and your patient for the new drug(s). For drugs which are used in 1<sup>st</sup> and 2<sup>nd</sup> line regimens please refer to the national guidelines for dosages and side effects.</p>
					<p>&nbsp;</p>
					<p>If you experience any difficulty or your patient develops side effects or you have other questions please contact:&nbsp;</p>
					<p>Committee member:</p>
					<p>Tel. number:</p>
					<p>Email:</p>
					<p>&nbsp;</p>
					<p>Please do not forget to do a Viral Load in 6 month to see whether your patient is virologically suppressed again. Please send the result to this email address.</p>
					<p>&nbsp;</p>
					<p>Thank you very much,</p>
					<p>&nbsp;</p>
					<p>Regards</p>
					<p>&nbsp;</p>  
					<p><?php echo $fullname; ?></p>  
					<p>3rd Line committee secretary</p>                                     

				</textarea>
				<p>Attachment: file Result <a href="cp_p1.php?rev">form#12.pdf</a></p>
				<hr />
				<h3>Other Attachements</h3>
				<label class="checkbox ">
					<input type="checkbox" name="checkbox_drv" id="checkbox" value="Prefab 3rd ART Communication ETV" > Prefab 3rd ART Communication ETV
				</label> 
				<label class="checkbox ">
					<input type="checkbox" name="checkbox_ral" id="checkbox" value="Prefab 3rd ART Communication DRV" > Prefab 3rd ART Communication DRV
				</label>
				<label class="checkbox ">
					<input type="checkbox" name="checkbox_etv" id="checkbox" value="Prefab 3rd ART Communication RAL" > Prefab 3rd ART Communication RAL
				</label>

				<hr />

				<p> Sending to: <u><?php echo $clinician_name; ?> </u>     Clinician at: <u><?php echo $art_clinic; ?> </u></p>
			</td>  
		</div>
		<div class="no box">
			<td>
				<h2>Switch is <U style="color:#f00">NOT</U> Indicated</h2>
				<h4>Comment to Clinician?</h4>

				<textarea type="text" class="span4" rows="8" name="decision_no"  id="area1" >
					<p>Dear&nbsp; <?php echo $clinician_name; ?></p>
					<p>&nbsp;</p>
					<p>Thank you for the application for resistance testing for your patient (Form #<?php echo $formID; ?>).</p>
					<p>&nbsp;</p>
					<p>We received your patient&rsquo;s resistance test results (attached). From the resistance mutations of your patient, the 3<sup>rd</sup> line committee concluded that switch of ART is indicated.</p>
					<p>The committee recommends:</p>
					<p>&nbsp;</p>
					<p>Comment 1:</p>
					<p>&nbsp;</p>
					<p>Comment 2:&nbsp;</p>
					<p>&nbsp;</p>
					<p>Comment 3:&nbsp;</p>
					<p>&nbsp;</p>
					<p>Thank you very much,</p>
					<p>Regards</p>
					<p>&nbsp;</p>
					<p><?php echo $fullname; ?></p>  
					<p>3rd Line committee secretary</p>                                     

				</textarea>
				<p>Attachment: file Result <a href="cp_p1.php?rev">form#12.pdf</a></p>
				<p> Sending to: <u><?php echo $clinician_name; ?> </u>     Clinician at: <u><?php echo $art_clinic; ?> </u></p>
			</td>  
		</div>
	</tr>
</table>
</td>    
</tr> 

<div class="form-actions">
	<div class="span3">
		<button class="btn" style="padding:10px; font-size:180%"><a href="cp_p1.php?rev">Cancel</a></button>
	</div> 
	<div class="span3">

	</div>

	<div class="span3">
		<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_consolidate2">Send</button> 
	</div>
</div>
</form>