<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('input[type="radio"]').click(function(){
			if($(this).attr("value")=="intr_Yes"){
				$(".box").not(".yes").hide();
				$(".yes").show();
			}
			if($(this).attr("value")=="intr_No"){
				$(".box").not(".no").hide();
				$(".no").show();
			}
			
		});
	});
</script>

<script>

	$().ready(function() {
		// validate the comment form when it is submitted
		$("#commentForm").validate();

		$("#search_art").validate({
			
			rules: {
				
				id: {
					required: true,
					
				},
				
			},
			messages: {
				id: {
					required: "",
				},
				
			}
		});

		// validate clinic status form on keyup and submit
		$("#edit-profile").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				
				who_stage: {
					required: true,
					
				},
				curr_who_stage: {
					required: true,
					
				},
				weight: {
					required: true,
					minlength: 2,
					maxlength: 3
				},
				height: {
					required: true,
					minlength: 3,
					maxlength: 3
				},
				
			},
			messages: {
				firstname: "Please enter Client's firstname",
				lastname: "Please enter Client's lastname",
				
				who_stage: {
					required: "Please Select WHO stage"
				},
				curr_who_stage: {
					required: "Please Select Current WHO stage"
				},
				weight: {
					required: "Curr Weight",
					minlength: "Under weight",
					maxlength: "Over weight"
					
				}, 
				height: {
					required: "Curr Height",
					minlength: "Under Height",
					maxlength: "Over Height"
					
				},
				
			}
		});

		
	});
</script>


<?php

global $pat_id;
if(isset($_GET['pat_id'])){ 
	$pat_id= $_GET['pat_id'];
	
}if(isset($_GET['xx'])){ 
	$age= $_GET['xx'];
}

$patient=mysqli_query( $bd,"SELECT * FROM patient where id='$pat_id' "); 
$row_pat=mysqli_fetch_array($patient);

$art_id_num =$row_pat['art_id_num'];
$firstname =$row_pat['firstname'];
$lastname =$row_pat['lastname'];
$gender =$row_pat['gender'];
$dob =$row_pat['dob'];
$vl_sample_id =$row_pat['vl_sample_id'];

$client_name = $firstname.' '.$lastname;

echo '
<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'&g='.$gender.'&xx='.$age.'" method="post">
	<h2 style="background-color:#f8f7f7; text-align:center">Current Clinic Status and history</h2>
	<hr style=" border: 1px solid #12c3f8;" />
	';                   
	?>
	<!--    <input type="text" name="pat_id" valu" style=" position:relative; top:-00px" />-->
	<h3>Client Name: <strong><i style="background-color:#f8f7f7; color:red"><?php echo $client_name; ?></i></strong></h3>
	<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>"  />

	<input type="hidden" name="dob" value="<?php echo $dob; ?>" />
	<fieldset>
		<table style="width:100%" border="0"  style="cellpadding:10px; ">
			<tr>
				<td><h4>WHO stage at start of Treatment</h4> <br /></td>
				<td>
					<select name="who_stage" id="who_stage" style="width:180px;height:50px;" required>
						<option value="">Select WHO stage</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select> <br />
					
				</td>    
				
				<td>
					<h4>Current WHO stage (+defining condition)</h4>  <br />
				</td>
				<td>
					<select name="curr_who_stage" id="curr_who_stage" style="width:200px; height:50px;">
						<option value="">Current WHO stage</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select> <br />
					
				</td>    
				
			</tr>
			<tr><td> <br /></td></tr>
			<tr>
				<td><h4>Curr Weight<label><span><i>*kg</i></span></label></h4></td>
				<td><input type="number" class="span4" id="weight" value="" placeholder="kg" name="weight" required style="width:100px; height:50px; font-size:130%">
					<br />
				</td>
				
				<td> <h4>Curr Height <label><span><i>*cm</i></span></label></h4></td>
				<td><input type="number" class="span4" id="height" value="" placeholder="cm" name="height" required style="width:100px; height:50px; font-size:130%">
					<br />
				</td>
				
			</tr>
			<tr><td> <br /></td></tr>
		</table>
	</fieldset>

	<fieldset>
		<h2 style="background-color:#f8f7f7; text-align:center">ART Interruptions</h2>
		<table style="width:100%" border="0" cellspacing="10px">
			
			<div class="box">
				<tr>
					
					<td>
						<h4>ART Interruptions?</h4>
						<div style="width:110px; float:left" class="radio_sty">
							<input type="radio" id="art_interrup" name="art_interrup" value="intr_Yes" required>
							<label for="art_interrup">Yes</label>
							
							<div class="check">
							</div>
						</div>
						<div style="width:100px; float:left" class="radio_sty">
							<input type="radio" id="nart_interrup" name="art_interrup" value="intr_No" >
							<label for="nart_interrup">No</label>
							
							<div class="check">
							</div>
						</div>
					</td>
					<td></td>
				</tr>
				
				<tr class="yes box">
					
					<td> <p>Write ART interruption dates (or ranges)</p>
						<textarea type="text" class="span4" rows="6"  name="art_interrup_date" value=""></textarea>
					</td>
					
					<td><p>Reason for interruption(s)</p>
						<textarea type="text" class="span4" rows="6"  name="art_interrup_reason" id="art_interupt_reason"></textarea>
					</td>
				</tr>
				
			</div>
		</table>
	</fieldset>
	<fieldset>
		<h2 style="background-color:#f8f7f7; text-align:center">History of serious side effects</h2>
		<table style="width:100%" border="0" cellspacing="10px">
			
			<tr>   
				<td>
					<h4 style="color:#fff">History of serious side effects</h4>
				</td>
				<td>
					<table>
						<?php
						$condition = [
						"PeripheralNeuropathy"=>'Perpheral Neuropathy',
						"Jaundice"=>'Jaundice',
						"Lipodystrophy"=>'Lipodystrophy',
						"KidneyFailure"=>'Kidney Failure',
						"Psychosis"=>'Psychosis',
						"Gynecomastia"=>'Gynecomastia',
						"Anemia"=>'Anemia'];
						$first=1;
						foreach ($condition as $key => $value) {
							echo "                                                                                  
							<tr>							
								<td></td>
								<td>
									<label class=\"control-label\">$value</label>
									<div style=\"width:110px; float:left\" class=\"radio_sty\">
										<input type=\"radio\" id=\"f-option\"   name=\"$key\" value=\"Yes\" required>
										<label for=\"f-option\">Yes</label>									
										<div class=\"check\">
										</div>
									</div>
									<div style=\"width:100px; float:left\" class=\"radio_sty\">
										<input type=\"radio\" id=\"n-option\" name=\"$key\" value=\"No\" >
										<label for=\"n-option\">No</label>									
										<div class=\"check\">
										</div>
									</div>
								</td>
							</tr>";
							if ($first == 2) {
								echo "</table>
							</td>";
							$first = 0;
						}
					}
					?> 
					<tr>
						
						<td> </td>
						
						<td>
							<table>
								<tr>
									
									<td>Other</td>
									<td> <input type="text" class="span4" name ="sdef_other"></td>
								</tr>
								
							</table>
						</td>
					</tr>
				</table>
			</table>
		</fieldset>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				$('input[name="ol_6months"]').on('click', function () {
					if ($(this).val() === 'Yes') {
						$('#datepicker1,#ol_6months_dign').prop("disabled", false);
					} else {
						$('#datepicker1,#ol_6months_dign').prop("disabled", "disabled");
					}
				});
			});
		</script>
		<fieldset>
			<table style="width:100%" border="0">
				
				<tr>
					<td>
						<label class="control-label">Ol in the last 6 month?</label>
						
						<div style="width:110px; float:left" class="radio_sty">
							
							<input type="radio" id="ol_6months-yes"  name="ol_6months" value="Yes"  required >
							<label for="ol_6months-yes">Yes</label>
							
							<div class="check">
							</div>
						</div>
						<div style="width:100px; float:left" class="radio_sty">
							<input type="radio" id="ol_6months-no" name="ol_6months" value="No" >
							<label for="ol_6months-no">No</label>
							
							<div class="check">
							</div>
						</div> 
					</td>    
					<td>
						If yes, Date <i>(dd/mm/yyyy)</i>
					</td>
					<td>
						<input type="text" class="span4" id="datepicker1" name="ol_6months_date">
					</td> 
				</tr>
				<tr>
					<td></td>
					<td>
						Diagnosis
					</td>
					<td>
						<textarea type="text" class="span4" id="ol_6months_dign" name="ol_6months_dign"></textarea>
					</td> 
					
				</tr>
				
				
			</table>
			
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$('input[name="sig_diarrhea_vom"]').on('click', function () {
						if ($(this).val() === 'Yes') {
							$('#sig_diarrhea_vom_details').prop("disabled", false);
						} else {
							$('#sig_diarrhea_vom_details').prop("disabled", "disabled");
						}
					});
				});
				
				jQuery(document).ready(function ($) {
					$('input[name="alco_drug_consump"]').on('click', function () {
						if ($(this).val() === 'Yes') {
							$('#alco_drug_consump_details').prop("disabled", false);
						} else {
							$('#alco_drug_consump_details').prop("disabled", "disabled");
						}
					});
				});   
				
				jQuery(document).ready(function ($) {
					$('input[name="trad_med"]').on('click', function () {
						if ($(this).val() === 'Yes') {
							$('#trad_med_details').prop("disabled", false);
						} else {
							$('#trad_med_details').prop("disabled", "disabled");
						}
					});
				});   
				
				
				jQuery(document).ready(function ($) {
					$('input[name="co_medi"]').on('click', function () {
						if ($(this).val() === 'Yes') {
							$('#co_medi_details').prop("disabled", false);
						} else {
							$('#co_medi_details').prop("disabled", "disabled");
						}
					});
				});    
				
				jQuery(document).ready(function ($) {
					$('input[name="other_curr_problem"]').on('click', function () {
						if ($(this).val() === 'Yes') {
							$('#other_curr_problem_details').prop("disabled", false);
						} else {
							$('#other_curr_problem_details').prop("disabled", "disabled");
						}
					});
				});    
			</script>


			<table style="width:100%" border="0">
				
				<tr>
					<td> 
						<label class="control-label">Significant diarrhea or vomiting?</label>
						
						<div style="width:110px; float:left" class="radio_sty">
							
							<input type="radio" id="sig_diarrhea_vom-yes" name="sig_diarrhea_vom" value="Yes" required >
							<label for="sig_diarrhea_vom-yes">Yes</label>
							
							<div class="check">
							</div>
						</div>
						<div style="width:100px; float:left" class="radio_sty">
							<input type="radio" id="sig_diarrhea_vom-no" name="sig_diarrhea_vom" value="No" >
							<label for="sig_diarrhea_vom-no">No</label>
							
							<div class="check">
							</div>
						</div> 
					</td>
					<td>
						Details
					</td>
					<td>
						<input type="text" class="span4" id="sig_diarrhea_vom_details" name="sig_diarrhea_vom_details">
					</td> 
				</tr> 
				
				<tr>
					<td> 
						<label class="control-label">Alcohol or drug consumption?</label>
						<div style="width:110px; float:left" class="radio_sty">
							
							<input type="radio" id="alco_drug_consump-yes" name="alco_drug_consump" value="Yes" required >
							<label for="alco_drug_consump-yes">Yes</label>
							
							<div class="check">
							</div>
						</div>
						<div style="width:100px; float:left" class="radio_sty">
							<input type="radio" id="alco_drug_consump-no" name="alco_drug_consump" value="No" >
							<label for="alco_drug_consump-no">No</label>
							
							<div class="check">
							</div>
						</div>    
						
						<td>
							Details
						</td>
						<td>
							<input type="text" class="span4" id="alco_drug_consump_details" name="alco_drug_consump_details">
						</td>    
					</tr> 
					
					<tr>
						<td> 
							<label class="control-label">Traditional medicine?</label>
							
							<div style="width:110px; float:left" class="radio_sty">
								
								<input type="radio" id="trad_med-yes" name="trad_med" value="Yes" required >
								<label for="trad_med-yes">Yes</label>
								
								<div class="check">
								</div>
							</div>
							<div style="width:100px; float:left" class="radio_sty">
								<input type="radio" id="trad_med-no" name="trad_med" value="No" >
								<label for="trad_med-no">No</label>
								
								<div class="check">
								</div>
							</div>    
						</td>
						<td>
							Details
						</td>
						<td>
							<input type="text" class="span4" id="trad_med_details" name="trad_med_details">
						</td>    
						
					</tr> 
					<tr>
						<td> 
							<label class="control-label">Current co-medications (Antiepileptic, Steroids, Warfarin, Statins)?</label>
							<div style="width:110px; float:left" class="radio_sty">
								
								<input type="radio" id="co_medi-yes"  name="co_medi" value="Yes" required >
								<label for="co_medi-yes">Yes</label>
								
								<div class="check">
								</div>
							</div>
							<div style="width:100px; float:left" class="radio_sty">
								<input type="radio" id="co_medi-no" name="co_medi" value="No" >
								<label for="co_medi-no">No</label>
								
								<div class="check">
								</div>
							</div>    
						</td>
						<td>
							Details
						</td>        
						<td>
							<input type="text" class="span4" name="co_medi_details" id="co_medi_details">
						</td>    
						
					</tr> 
					
					<tr>
						<td> 
							<label class="control-label">Other current clinical problems?</label>
							
							<div style="width:110px; float:left" class="radio_sty">
								
								<input type="radio" id="other_curr_problem-yes"  name="other_curr_problem" value="Yes" required >
								<label for="other_curr_problem-yes">Yes</label>
								
								<div class="check">
								</div>
							</div>
							<div style="width:100px; float:left" class="radio_sty">
								<input type="radio" id="other_curr_problem-no" name="other_curr_problem" value="No" >
								<label for="other_curr_problem-no">No</label>
								
								<div class="check">
								</div>
							</div>    
						</td>
						<td>
							Details
						</td>        
						<td>
							<input type="text" class="span4" name="other_curr_problem_details" id="other_curr_problem_details" style="height: 40px;">
						</td>    
						
					</tr> 
				</table>
			</fieldset>
			<div class="form-actions">
				<div class="span3">
					<a href="app.php?back&part_1<?php echo '&pat_id='.$pat_id.'' ?>" class="btn" style="padding:10px; font-size:180%">Back</a>                                                                                                                                    </div>
					<div class="span3">
					</div>
					
					<div class="span3">
						<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_clinicstatus">Next</button> 
					</div>
				</div>
				
			</form>