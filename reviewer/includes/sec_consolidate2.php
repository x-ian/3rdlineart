<?php
$comments = [];
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="radio"]').click(function(){
			if($(this).attr("value")=="SwitchYes"){
				$(".box").not(".yes").hide();
				$(".yes").show();
			}
			if($(this).attr("value")=="SwitchNo"){
				$(".box").not(".no").hide();
				$(".no").show();
                // alert('<?php $comments[0]; ?>');
                $('#comment1').html('<?php $comments[0]; ?>');
                $('#comment2').html('<?php $comments[1]; ?>');
                $('#comment3').html('<?php $comments[2]; ?>');                
			}
		});
 
        $('button[type="submit"]').click(function(){
            // alert($("#div_decision").html());
            if ($('#switch').is(':checked'))
                $("#decision").val($("#div_decision_yes").html());
            else
                $("#decision").val($("#div_decision_no").html());                
        });

        $('input[type="checkbox"]').click(function(){
            // alert($(this).attr("id"));
            // $("#rec_drugs").text("hey");
            var checkedVals = $('input.cb_drugs:checkbox:checked').map(function() {
                return this.value;
            }).get();
            var html = [];
            for(var i=0; i<checkedVals.length; i++) {
                html.push('<br>Drug'+(i+1)+': '+checkedVals[i]);
                // alert(checkedVals[i]);
            }
            $("#rec_drugs").html(html);
        });
	});
</script>
<?php
global $formID, $rooturl;
$formID= $_GET['formid'];

$app = new Application($formID);
// echo "<br>lead reviewer is: ".$app->lead_reviewer();

$form_creation=mysqli_query( $bd,"SELECT * FROM form_creation where 3rdlineart_form_id ='$formID'");

while ($row_form_creation=mysqli_fetch_array($form_creation)){
	$clinician_id =$row_form_creation['clinician_id'];
	$patient_id =$row_form_creation['patient_id'];

	$SQL_clinician = "SELECT * FROM clinician WHERE id = $clinician_id";
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

echo '<form id="edit-profile" class="form-horizontal" action="reviewer_p1.php?p" method="post" style="background-color:#ddf; padding:10px;">';
?>
<tr>
	<?php
	$expert_review_result=mysqli_query( $bd,"SELECT * FROM expert_review_result where form_id ='$formID' "); 

    $cons_drugs = [];
    $rev_name = [];

	while ($row_expert_review_result=mysqli_fetch_array($expert_review_result)){
		$rev_id = $row_expert_review_result['rev_id'];
		$pi_mutation =$row_expert_review_result['pi_mutation'];
		$switch =$row_expert_review_result['switch'];
        // echo "$rev_id:$switch";
        
		$drug1 = $row_expert_review_result['drug1'];
		$drug2 = $row_expert_review_result['drug2'];
		$drug3 = $row_expert_review_result['drug3'];
		$drug4 = $row_expert_review_result['drug4'];
		$drug5 = $row_expert_review_result['drug5'];
		$comment  = $row_expert_review_result['comment'];
		$feedback_to_clinician  = $row_expert_review_result['feedback_to_clinician'];
        array_push($comments, $switch=='Yes' ? $comment : $feedback_to_clinician);
        
		$select_reviewer = mysqli_query( $bd,"SELECT * FROM reviewer where id = '$rev_id'"); 
		$row_select_reviewer = mysqli_fetch_array($select_reviewer);
		$rev_fname  = $row_select_reviewer['fname']; 
		$rev_lname  = $row_select_reviewer['lname']; 
		$rev_title  = $row_select_reviewer['title']; 

		$rev_fullname = $rev_title.'.  '.$rev_fname.' '.$rev_lname;
        $rev_name[$rev_id] = $rev_fullname;
        for($i=1; $i<=5; $i++) {
            eval("\$drug = \$row_expert_review_result['drug$i'];");
            if ($switch == 'No')
                continue;
            if ($drug == 'none')
                continue;
            // echo "drug $drug, $switch, <br>";            
            if (!array_key_exists($drug, $cons_drugs))
                $cons_drugs[$drug] = [$rev_id];
            else
                if (!in_array($rev_id, $cons_drugs[$drug])) {
                    array_push($cons_drugs[$drug], $rev_id);
                    // echo "<br>push $rev_id for $drug";
                }
        }

		echo ' 
		<table class="table table-striped table-bordered" title="Reviewer 1" style="width:32.2%; float:left; margin:2px;">
			<th><h4 style="text-align:center;">Reviewer : <strong><u> '.$rev_fullname.'</u></strong></h4></th>
			<tr><td>
				<p>PI Mutation present: '.$pi_mutation.'</p>
				<p>Switch: '.$switch.'</p>';
				if ($switch=='Yes'){
					echo '<table border="1" style="width:99%">
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
					'.$comment.'
 				</p>';
			}

			else {
				echo  '<p><strong><u>Feedback to Clinician: </u></strong></p>
				<p>'.$feedback_to_clinician."</p>
				";
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
<form id="edit-profile" class="form-horizontal" action="review_p1.php?p" method="post" style="background-color:#e5e5e5; padding:20px; width:100%; float:left">
    <input type="hidden" name="decision" id="decision" value="" />
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
	<table style="width:100%">
		<tr>                     <td>
			<h4>Is PI mutation present?</h4>

			<div style="width:110px; float:left" class="radio_sty">
				<input type="radio" id="pi_mutation" name="pi_mutation" value="Yes_pi" required>
				<label for="pi_mutation">Yes</label>
				<div class="check">
				</div>
			</div>
			<div style="width:100px; float:left" class="radio_sty">
				<input type="radio" id="npi_mutation" name="pi_mutation" value="No_pi">
				<label for="npi_mutation">No</label>
				<div class="check">
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>                          
			<h4>Is Switch indicated?</h4> 
			<div style="width:110px; float:left" class="radio_sty span12">
				<input type="radio" id="switch"  name="switch" value="SwitchYes"  required>
				<label for="switch">Yes</label>
				<div class="check">
				</div>
			</div>
			<div style="width:100px; float:left" class="radio_sty">
				<input type="radio" id="nswitch" name="switch" value="SwitchNo" >
				<label for="nswitch">No</label>
				<div class="check">
				</div>
			</div>
			<input type="hidden" name="clinician_email" value="<?php echo $clinician_email; ?>" />
			<input type="hidden" name="clinician_name" value="<?php echo $clinician_name; ?>" />
			<input type="hidden" name="formid" value="<?php echo $formID; ?>" />

		</td></tr>
	</table>

<div class="yes box">
<?php        
echo '<table><tr><td><h3>Select the New Regimen based on the Reviewers Choices</h3></td></tr> <tr><td>';
            foreach($cons_drugs as $key => $value) {
                $reviewers="";
                for($i=0; $i<count($value); $i++)
                    $reviewers = $reviewers.($reviewers == ''?'':', ').$rev_name[$value[$i]];
                echo "<tr><td><label class=\"checkbox\"><input type=\"checkbox\" class=\"cb_drugs\" id=\"$key\" value=\"$key\">$key: $reviewers</label>";
                echo '</td></tr>';
            }
echo '</table>';
// echo '</td></tr></table>';

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
        
		<table style="width:100%; font-size:120%; position:relative; top:-20px;" >
			<hr />
			<tr>
				<td><h2>Switch Indicated</h2>
					<h4>Comment to Clinician?</h4>
					<!-- <textarea type="text" class="span4" rows="8" name="decision"  id="area1" > -->
    <div id="div_decision_yes" contenteditable="true" style="background-color: white; border: 1px solid #ccc; padding: 5px; ">
                    
    <p>Dear&nbsp; <?php echo $clinician_name; ?>,</p>
						<p>&nbsp;</p>
						<p>Thank you for the application for resistance testing for your patient <strong>(Form #<?php echo $formID; ?>)</strong>.</p>
						<p>&nbsp;</p>
						<p>We received your patient&rsquo;s resistance test results  <a href="<?php echo "$rooturl/app.php?conso2view&formid=$formID&redirect_after";?>">Click Here to View</a> . From the resistance mutations of your patient, the 3<sup>rd</sup> line committee concluded that switch of ART <b>IS</b> indicated.</p>
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
                                <tr><td><span id="rec_drugs"></span><td></tr>
 							</tbody>
						</table>
						<p>&nbsp;</p>
						<p>Comment from reviewers:</p>
                        <p><strong>[ Lead Reviewer - Please enter a comment here summarizing the reason for these recommendations ]</strong></p> 
						<p>&nbsp;</p>
						<p>You will receive the drugs from the DHA within the next weeks. If you have any problems receiving the 3<sup>rd</sup> line drugs, please contact Supply chain at DHA.</p>
						<p>Contact person:</p>
						<p>Tel Number:</p>
						<p>Email:</p>
						<p>&nbsp;</p>
						<p>Please find attached information for you and your patient for the new drug(s). For drugs which are used in 1<sup>st</sup> and 2<sup>nd</sup> line regimens please refer to the national guidelines for dosages and side effects.</p>
						<p>&nbsp;</p>
						<p>If you experience any difficulty or your patient develops side effects or you have other questions please contact:&nbsp;</p>
						<p>Committee member: <strong><?php echo $app->lead_reviewer();?></strong> </p>
						<p>Tel. number: <strong><?php echo $app->lead_reviewer('phone');?></strong> </p>
						<p>Email: <strong><?php echo $app->lead_reviewer('email');?></strong> </p>
						<p>&nbsp;</p>
						<p>Please do not forget to do a Viral Load in 6 month to see whether your patient is virologically suppressed again. Please send the result to this email address:</p>
                        <p><strong><?php echo "Secretariat email"; ?></strong></p>
						<p>&nbsp;</p>
						<p>Thank you very much,</p>
						<p>&nbsp;</p>
						<p>Regards</p>
						<p>&nbsp;</p>  
						<p><?php echo $fullname; ?></p>  
						<p>3rd Line committee secretary</p>                                     

					<!-- </textarea> -->
                        </div>
					<p>Login to view Result</p>
					<hr />
					<h3>Other Attachments</h3>
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
					<p> Sending to: <u><?php echo $clinician_name; ?> </u>   Clinician at: <u><?php echo $art_clinic; ?> </u></p>
				</td> 
			</tr></table>
			<div class="form-actions">
				<div class="span3">
					<button class="btn" style="padding:10px; font-size:180%"><a href="review_p1.php?rev">Cancel</a></button>
				</div>
				<div class="span3"></div>

				<div class="span3">
					<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_consolidate2">Send</button> 
				</div>
			</div>			
		</div>
				
		<div class="no box">			
			<table style="width:100%; font-size:120%; position:relative; top:-20px;" >
				<hr />
				<tr>
					<td>
						<h2>Switch is <U style="color:#f00">NOT</U> Indicated</h2>
						<h4>Comment to Clinician?</h4>
						
						<!-- <textarea type="text" class="span4" rows="8" name="decision_no" id="area1" > -->
    <div id="div_decision_no" contenteditable="true" style="background-color: white; border: 1px solid #ccc; padding: 5px; ">							<p>Dear&nbsp; <?php echo $clinician_name; ?></p>
							<p>&nbsp;</p>
							<p>Thank you for the application for resistance testing for your patient (Form #<?php echo $formID; ?>).</p>
							<p>&nbsp;</p>
							<p>We received your patient&rsquo;s resistance test results (attached). From the resistance mutations of your patient, the 3<sup>rd</sup> line committee concluded that switch of ART is <b>NOT</b> indicated.</p>
							<p>The committee recommends:</p>
							<p>&nbsp;</p>
							<p>Comment 1:</p>
                            <?php echo $comments[0]; ?>
							<p>&nbsp;</p>
							<p>Comment 2:&nbsp;</p>
                            <?php echo $comments[1]; ?>                          
							<p>&nbsp;</p>
							<p>Comment 3:&nbsp;</p>
                            <?php echo $comments[2]; ?>                            
							<p>&nbsp;</p>
							<p>Thank you very much,</p>
							<p>Regards</p>
							<p>&nbsp;</p>
							<p><?php echo $fullname; ?></p>  
							<p>3rd Line committee secretary</p>                                     
							</div>
						<!-- </textarea> -->
						<p>Attachment: file Result <a href="cp_p1.php?rev">form#12.pdf</a></p>
						<p> Sending to: <u><?php echo $clinician_name; ?> </u>     Clinician at: <u><?php echo $art_clinic; ?> </u></p>
					</td>  
				</div>
			</tr>
						
		</table>
		
		<div class="form-actions">
			<div class="span3">
				<button class="btn" style="padding:10px; font-size:180%"><a href="review_p1.php?rev">Cancel</a></button>
			</div>
			<div class="span3">                        
			</div>
			
			<div class="span3">
				<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_consolidate2">Send</button> 
			</div>
		</div>
		
		
	</form>