<style>
.control-label-r {
    max-width: 150px;
    margin: 0px 20px 20px 5px;
    float: left;
    font-size: 18px;    
}
</style>
<h2 style="background-color:#f8f7f7; text-align:center">Pediatric Section</h2>
<hr style=" border: 2px solid #5e09e5;" />
<?php

global $pat_id;
$pat_id= $_GET['pat_id'];

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

echo '<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'" method="post">';
exit();
?> 
<h3>Client Name: <strong><i style="color:red"><?php echo $client_name; ?></i></strong></h3>

<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>"   />
<input type="hidden" name="dob" value="<?php echo $patient->dob; ?>"  /> 

<table style="width:100%" border="0">
	<tr>
		<td>
			<label class="control-label-r">Has mother had single dose NVP?</label>
			<div style="width:110px; float:left" class="radio-btn">
				<input type="radio" class="radio-btn" id="yes_mother_had_single_dose_NVP" name="mother_had_single_dose_NVP" value="Yes">
				<label for="yes_mother_had_single_dose_NVP">Yes</label>
			</div>
			<div style="width:100px; float:left" class="radio-btn">
				<input type="radio" class="radio-btn" id="no_mother_had_single_dose_NVP" name="mother_had_single_dose_NVP" value="No" >
				<label for="no_mother_had_single_dose_NVP">No</label>
			</div>
		</td>    

		<td>
			<label class="control-label-r">Has mother had PMTCT?</label>
			<div style="width:110px; float:left" class="radio-btn">
				<input type="radio" class="radio-btn" id="yes_given_NVP" name="given_NVP" value="Yes" >
				<label for="yes_given_NVP">Yes</label>
			</div>
			<div style="width:100px; float:left" class="radio-btn">
				<input type="radio" class="radio-btn" id="no_given_NVP" name="given_NVP" value="No" >
				<label for="no_given_NVP">No</label>
			</div>

		</td>    
	</tr>  
	<table style="width:100%" border="0">
		<tr>
			<td>
				<label class="control-label-r">Was baby given NVP?</label>
				<div style="width:110px; float:left" class="radio-btn">
					<input type="radio" class="radio-btn" id="yes_mother_had_PMTCT" name="mother_had_PMTCT" value="Yes" >
					<label for="yes_mother_had_PMTCT">Yes</label>
				</div>
				<div style="width:100px; float:left" class="radio-btn">
					<input type="radio" class="radio-btn" id="no_mother_had_PMTCT" name="mother_had_PMTCT" value="No" >
					<label for="no_mother_had_PMTCT">No</label>
				</div>
			</td>    

			<td>
				<label class="control-label-r">Is the child able to swallow tablets?</label>
				<div style="width:110px; float:left" class="radio-btn">
					<input type="radio" class="radio-btn" id="yes_swallow_tablets" name="swallow_tablets" value="Yes" >
					<label for="yes_swallow_tablets">Yes</label>
				</div>
				<div style="width:100px; float:left" class="radio-btn">
					<input type="radio" class="radio-btn" id="no_swallow_tablets" name="swallow_tablets" value="No" >
					<label for="no_swallow_tablets">No</label>
				</div>
			</td>    
		</tr>  
	</table>
</table>
<div class="form-actions">
	<div class="span3">
		<button class="btn" style="padding:10px; font-size:180%"><a href="app.php?back&part_2<?php echo '&pat_id='.$pat_id.'' ?>">Back</a></button>
	</div> 
	<div class="span3">
	</div>
	<div class="span3">
		<button type="submit" name="submit_pediatric" class="btn btn-success" style="padding:10px; font-size:180%">Next</button>
	</div>
</div>
</form>