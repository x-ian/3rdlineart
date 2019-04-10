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
</script>
        
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

//pediatric age < 3
$pediatric=mysqli_query( $bd,"SELECT * FROM pediatric where pat_id='$pat_id' "); 
$row_pediatric=mysqli_fetch_array($pediatric);

$mother_had_single_dose_NVP =$row_pediatric['mother_had_single_dose_NVP'];
$given_NVP =$row_pediatric['given_NVP'];
$mother_had_PMTCT =$row_pediatric['mother_had_PMTCT'];
$swallow_tablets =$row_pediatric['swallow_tablets'];

echo '
<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'" method="post">';
	?> 

	<h3>Client Name: <strong><i style="color:red"><?php echo $client_name; ?></i></strong></h3>
	<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>"   />
	<input type="hidden" name="dob" value="<?php echo $patient->dob; ?>"  /> 
<br>
	<table style="width:100%" border="0">
		<tr>
			<td>
				<label class="control-label-r">Has mother had single dose NVP?</label>
				<div style="width:110px; float:left" class="radio-btn">
					<input type="radio" id="yes_mother_had_single_dose_NVP" name="mother_had_single_dose_NVP" required value="Yes" <?php 
					if (!empty ($mother_had_single_dose_NVP)) { if ($mother_had_single_dose_NVP =='Yes') { echo  'checked="checked"';} } ?>>
					<label for="yes_mother_had_single_dose_NVP">Yes</label>
				</div>
				<div style="width:100px; float:left" class="radio-btn">
					<input type="radio" id="no_mother_had_single_dose_NVP" name="mother_had_single_dose_NVP" value="No" <?php 
					if (!empty ($mother_had_single_dose_NVP)) { if ($mother_had_single_dose_NVP =='No') { echo  'checked="checked"';} } ?> >
					<label for="no_mother_had_single_dose_NVP">No</label>
				</div>
			</td>    

			<td>
				<label class="control-label-r">Has mother had PMTCT?</label>
				<div style="width:110px; float:left" class="radio-btn">
					<input type="radio" id="yes_given_NVP" name="given_NVP" required  value="Yes" <?php 
					if (!empty ($given_NVP)) { if ($given_NVP =='Yes') { echo  'checked="checked"';} } ?> >
					<label for="yes_given_NVP">Yes</label>
				</div>
				<div style="width:100px; float:left" class="radio-btn">
					<input type="radio" id="no_given_NVP" name="given_NVP" value="No" <?php 
					if (!empty ($given_NVP)) { if ($given_NVP =='No') { echo  'checked="checked"';} } ?> >
					<label for="no_given_NVP">No</label>
				</div>
			</td>    
		</tr>  
        <tr>
            <td>
                <label class="control-label-r">Was baby given NVP?</label>
                <div style="width:110px; float:left" class="radio-btn">
                    <input type="radio" id="yes_mother_had_PMTCT" name="mother_had_PMTCT" required  value="Yes" <?php 
                    if (!empty ($mother_had_PMTCT)) { if ($mother_had_PMTCT =='Yes') { echo  'checked="checked"';} } ?>>
                    <label for="yes_mother_had_PMTCT">Yes</label>
                </div>
                <div style="width:100px; float:left" class="radio-btn">
                    <input type="radio" id="no_mother_had_PMTCT" name="mother_had_PMTCT" value="No" <?php 
                    if (!empty ($mother_had_PMTCT)) { if ($mother_had_PMTCT =='No') { echo  'checked="checked"';} } ?> >
                    <label for="no_mother_had_PMTCT">No</label>
                </div>
            </td>    

            <td>
                <label class="control-label-r">Is the child able to swallow tablets?</label>
                <div style="width:110px; float:left" class="radio-btn">
                    <input type="radio" id="yes_swallow_tablets" name="swallow_tablets" required  value="Yes" <?php 
                    if (!empty ($swallow_tablets)) { if ($swallow_tablets =='Yes') { echo  'checked="checked"';} } ?> >
                    <label for="yes_swallow_tablets">Yes</label>
                </div>
                <div style="width:100px; float:left" class="radio-btn">
                    <input type="radio" id="no_swallow_tablets" name="swallow_tablets" value="No" <?php 
                    if (!empty ($swallow_tablets)) { if ($swallow_tablets =='No') { echo  'checked="checked"';} } ?> >
                    <label for="no_swallow_tablets">No</label>
                </div>

            </td>    
        </tr>  
	</table>
	<div class="form-actions">
		<div class="span3">
			<a class="btn" href="app.php?back&part_2&app_clin<?php echo '&pat_id='.$pat_id.'&g='.$patient->gender.'&xx='.$patient->age.'' ?>" style="padding:10px; font-size:180%">Back</a>      
		</div>                                             
		<div class="span3">
			<?php include ('includes/app_edit_menu.php'); ?>
		</div>
		<div class="span3">
            <?php
            if ($_POST['submit_clinicstatus'])
			    echo '<button type="submit" name="submit_pediatric" class="btn btn-success" style="padding:10px; font-size:180%">Next</button>';
            else
			    echo '<button type="submit" name="update_pediatric" class="btn btn-success" style="padding:10px; font-size:180%">Next</button>';
            ?>
		</div>
	</div>
</form>