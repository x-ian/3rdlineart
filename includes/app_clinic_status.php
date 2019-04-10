<script type="text/javascript">
	$(document).ready(function(){
        // $('#edit-profile').parsley();        
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
					required: "need this!",
				},
			}
		});

		// validate clinic status form on keyup and submit
		$("#edit-profile").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				
				who_stage: {
					required: false,					
				},
				curr_who_stage: {
					required: false,					
				},
				weight: {
					required: true,
                        range: [10, 250],
				},
				height: {
					required: true,
                        range: [30, 300],
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
				}, 
				height: {
					required: "Curr Height",

				},
			}
		});
	});
</script>

<?php
global $pat_id;
if(isset($_GET['pat_id'])){ 
	$pat_id= $_GET['pat_id'];
}

// echo "about to query $pat_id";
$patient = new Patient($pat_id);
$client_name = $patient->fullname;

echo '
<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'&g='.$patient->gender.'&xx='.$patient->age.'" method="post">
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
                    <input name="who_stage" id="who_stage" style="width:200px; height:50px;" value="" placeholder="Number or Text">                    
					<!-- <select name="who_stage" id="who_stage" style="width:180px;height:50px;">
						<option value="">Select WHO stage</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select> --><br />
					
				</td>    
				
				<td>
					<h4>Current WHO stage (+defining condition)</h4>  <br />
				</td>
				<td>
                    <input name="curr_who_stage" id="curr_who_stage" style="width:200px; height:50px;" value="" placeholder="Number or Text">
					<!-- <select name="curr_who_stage" id="curr_who_stage" style="width:200px; height:50px;">
						<option value="">Current WHO stage</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select> --><br />
					
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
									<div style=\"width:120px; float:left\" class=\"radio_sty\">
										<input type=\"radio\" id=\"$key-yes\" name=\"$key\" value=\"Yes\" required >
										<label for=\"$key-yes\">Yes</label>
									    <div class=\"check\">
										</div>
									</div>
									<div style=\"width:100px; float:left\" class=\"radio_sty\">
										<input type=\"radio\" id=\"$key-no\" name=\"$key\" value=\"No\">
										<label for=\"$key-no\">No</label>
										<div class=\"check\">
										</div>
									</div>
								</td>
							</tr>";
							if ($first == 1) {
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
							
							<input type="radio" id="ol_6months-yes"  name="ol_6months" value="Yes" >
							<label for="ol_6months-yes">Yes</label>
							
							<div class="check">
							</div>
						</div>
						<div style="width:100px; float:left" class="radio_sty">
							<input type="radio" id="ol_6months-no" name="ol_6months" value="No" required >
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
				<?php
				$condition = [
				"sig_diarrhea_vom"=>"Significant diarrhea or vomiting?",
				"alco_drug_consump"=>"Alcohol or drug consumption?",
				"trad_med"=>"Traditional medicine?",
				"co_medi"=>"Current co-medications (Antiepileptic, Steroids, Warfarin, Statins)?",
				"other_curr_problem"=>"Other current clinical problems?"
				];

				foreach ($condition as $key => $value) {
					echo "jQuery(document).ready(function ($) {
						$('input[name=\"$key\"]').on('click', function () {
							if ($(this).val() === 'Yes') {
								$('#".$key."_details').prop(\"disabled\", false);
							} else {
								$('#".$key."_details').prop(\"disabled\", \"disabled\");
							}
						});
					});";
				}
				echo "
			</script>
			<table style=\"width:100%\" border=\"0\">";

				foreach ($condition as $key => $value) {
					echo "				
					<tr>
						<td> 
							<label class=\"control-label\">$value</label>
							<div style=\"width:110px; float:left\" class=\"radio_sty\">
								<input type=\"radio\" id=\"$key-yes\" name=\"$key\" value=\"Yes\" >
								<label for=\"$key-yes\">Yes</label>
								<div class=\"check\">
								</div>
							</div>
							<div style=\"width:100px; float:left\" class=\"radio_sty\">
								<input type=\"radio\" id=\"$key-no\" name=\"$key\" value=\"No\" required >
								<label for=\"$key-no\">No</label>
								<div class=\"check\">
								</div>
							</div> 
						</td>
						<td>
							Details
						</td>
						<td>
							<input type=\"text\" class=\"span4\" id=\"".$key."_details\" name=\"".$key."_details\">
						</td> 
					</tr> ";
				}
				?>
			</table>
		</fieldset>
		<div class="form-actions">
			<div class="span3">
				<a href="app.php?back&part_1<?php echo '&pat_id='.$pat_id.'' ?>" class="btn" style="padding:10px; font-size:180%">Back</a></div>
				<div class="span3">
				</div>
				<div class="span3">
					<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_clinicstatus">Next</button> 
				</div>
			</div>

		</form>