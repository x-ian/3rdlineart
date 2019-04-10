<script type="text/javascript">
	$(document).ready(function(){
		if ($('input[id="yes_pregnant"]').attr("checked") == 'checked') {
			$(".box").not(".yes").hide();
			$(".yes").show();
		} else {
			$(".yes").hide();
		}
		$('input[type="radio"]').click(function(){
			if($(this).attr("value")=="Yes_preg"){
				$(".box").not(".yes").hide();
				$(".yes").show();
			}
			if($(this).attr("value")=="No_preg"){
				$(".box").not(".no").hide();
				$(".no").show();
			}
		});
	});


	$().ready(function() {
        // validate the form when it is submitted

        $("#edit-profile").validate({
          rules: {
              pregnant: {
                  required: ALL
                        },                
              },
                
           messages: {
              pregnant: {
                  required: "required"
                        },
              },
                
                // focusInvalid: false

        });
    });
</script>

<?php

global $pat_id;
$pat_id= $_GET['pat_id'];

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

//pregnacy for females age greater than 10
$pregnancy = mysqli_query( $bd,"SELECT * FROM pregnancy where pat_id='$pat_id' "); 
$row_pregnancy = mysqli_fetch_array($pregnancy);

$pregnant = $row_pregnancy['pregnant'];
$weeks_o_preg = $row_pregnancy['weeks_o_preg'];
$breastfeeding = $row_pregnancy['breastfeeding'];

echo '
<form id="edit-profile" class="form-horizontal" action="app.php?pat_id='.$pat_id.'&g='.$patient->gender.'&xx='.$patient->age.'" method="post">
	';
	?>
	<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>" />
	<input type="hidden" name="dob" value="<?php echo $dob; ?>" /> 
	<h2 style="background-color:#f8f7f7; text-align:center"> Pregnancy Section</h2>
	<h3>Client Name: <strong><i style="background-color:#f8f7f7; color:red"><?php echo $client_name; ?></i></strong></h3>
	<hr style=" border: 2px solid #1c952f;" />
	<fieldset>
		<table style="width:100%" border="0">
			<div class="box">
				<tr>
				    <td style="width:200px; margin: 20px 0px 20px 0px; float:right; font-size:18px">Is the patient currently pregnant?</td><td>
						<div style="width:110px; float:left" class="radio-btn">
							<input type="radio" id="yes_pregnant" name="pregnant" value="Yes_preg"  <?php if ($pregnant=='Yes'){ echo ' checked="checked" '; } ?> required>
							<label for="yes_pregnant">Yes</label>
							</div>
						</div>
						<div style="width:100px; float:left" class="radio-btn">
							<input type="radio" id="no_pregnant" name="pregnant" value="No_preg" <?php if ($pregnant=='No'){ echo ' checked="checked" '; } ?>>
							<label for="no_pregnant">No</label>
							</div>
						</div>
					</td>    

					<td class="yes box">
						<p>Week of Pregnancy </p>
					</td>
					<td class="yes box">
						<select name="weeks_o_preg">
							<?php
							if ($pregnant=='Yes'){
								echo '<option>'.$weeks_o_preg.'</option>';
							} 
							if ($pregnant=='No'){
								echo '<option></option>';
							}
							for ($wk=0; $wk < 60; $wk ++ ){
								echo '<option>'.$wk.'</option>';
							}
							?>
						</select>
					</td> 
				</tr>
			</div>
		</table>
	</fieldset>
	<fieldset>
		<table style="width:100%" border="0">
			<tr>
				<td style="width:200px; margin: 20px 0px 20px 0px; float:right; font-size:18px">Is the patient breastfeeding?</td><td>                                
					<div style="width:110px; float:left" class="radio-btn">
						<input type="radio" id="yes_breastfeeding" name="breastfeeding" value="Yes"  <?php 
						if ($breastfeeding=='Yes'){ echo ' checked="checked" '; } ?> required>
						<label for="yes_breastfeeding">Yes</label>
						</div>
					</div>
					<div style="width:100px; float:left" class="radio-btn">
						<input type="radio" id="no_breastfeeding" name="breastfeeding" value="No" <?php 
						if ($breastfeeding=='No'){ echo ' checked="checked" '; } ?> >
						<label for="no_breastfeeding">No</label>
						</div>
					</div>
				</td>    
		</tr>
	</table>
</fieldset>
                
<div class="form-actions">
	<div class="span3">
		<a class="btn" href="app.php?back&part_2&back_preg<?php echo '&pat_id='.$pat_id.'&g='.$patient->gender.'&xx='.$patient->age.'' ?>" style="padding:10px; font-size:180%">Back</a>
	</div>
	<div class="span3">
        <?php include ('includes/app_edit_menu.php'); ?>
    </div>
	<div class="span3">
		<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="update_Preg">Next</button> 
	</div>
	</div>
</form>
