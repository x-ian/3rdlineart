<h2 style="background-color:#f8f7f7; text-align:center"> ART Adherence</h2>
<!-- <hr style=" border: 2px solid #1c952f;" />-->

<?php 
global $pat_id;
$pat_id= $_GET['pat_id'];

global $location;
if(isset($_POST['submit_clinicstatus'])){ 
	$location ="app.php";  
} else {
	$location ="complete_form.php";  
}

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

// echo 'action="'.$location.'?pat_id='.$pat_id.'"';
echo '<form id="edit-profile" class="form-horizontal" action="'.$location.'?pat_id='.$pat_id.'" method="post">';
?>

	<h3>Client Name: <strong><i style="color:red"><?php echo $client_name; ?></i></strong></h3>

	<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>"  /> 
	<input type="hidden" name="dob" value="<?php echo $patient->dob; ?>" /> 
	<script>
		$( function() {
			$( "#datepickersVis_Date1" ).datepicker({
				changeMonth: true,
				changeYear: true
			});
		} );
	</script>     
	<script>
		$( function() {
			$( "#datepickeraVis_Date1" ).datepicker({
				changeMonth: true,
				changeYear: true
			});
		} );
	</script>     
	<script>
		$( function() {
			$( "#datepickersVis_Date2" ).datepicker({
				changeMonth: true,
				changeYear: true
			});
		} );
	</script>     
	<script>
		$( function() {
			$( "#datepickeraVis_Date2" ).datepicker({
				changeMonth: true,
				changeYear: true
			});
		} );
	</script>     
	<script>
		$( function() {
			$( "#datepickersVis_Date3" ).datepicker({
				changeMonth: true,
				changeYear: true
			});
		} );
	</script>     
	<script>
		$( function() {
			$( "#datepickeraVis_Date3" ).datepicker({
				changeMonth: true,
				changeYear: true
			});
		} );
	</script>     
	<fieldset>
		<h3>Adherence Section <i>(Patient adherence in the last 3 visits)</i></h3>
		<table style="width:100%" border="0">
			<tbody>
				<?php     
				for($i=1; $i<=3; $i++) {
					eval("\$scheduled_visit_date = !empty ( \$scheduled_visit_date$i) ? \$scheduled_visit_date$i : '';");
					eval("\$actual_visit_date = !empty ( \$actual_visit_date$i) ? \$actual_visit_date$i : '';");
					eval("\$pill_count = !empty ( \$pill_count$i) ? \$pill_count$i : '';");
					// echo "date is ".$scheduled_visit_date;
        $svd = $scheduled_visit_date; // if I dont do this, the code doesn't work
        echo "<tr>
        <td> <h4>Schedule visit date:</h4><label><i>(dd/mm/yyyy)</i></label> </td>
        <td> <input type=\"text\" name=\"scheduled_visit_date$i\" id=\"datepickersVis_Date$i\"  value=\"$svd\" onchange=\"updatedate();\"/> </td>
        <td> <h4>Actual visit date </h4><label><i>(dd/mm/yyyy)</i></td>
        <td> <input type=\"text\" name=\"actual_visit_date$i\" id=\"datepickeraVis_Date$i"."2\" required value=\"$actual_visit_date\" /> </td>
        <td> <h4>Pill Count (%) </h4> </td>
        <td> <input type=\"number\" name=\"pill_count$i\" id=\"pill_count$i\" style=\"width:80px; height:50px;\"  value=\"$pill_count\"/> </td>
    </tr>";
}
?>
</tbody>
</table>
</fieldset>
<hr style=" border: 1px solid #cbe509;" />
<fieldset>
	<h3>Adherence questions <i>(circle answer)</i></h3>
	<table>
    	<?php
		$questions = ["ever_forget_2_take_meds"=>"Do you ever forget to take your medicine?",
		"careless_taking_meds"=>"Are you careless at times about taking your medicine?",
		"stop_taking_meds"=>"Sometimes if you feel worse, do you stop taking your medicine?",
		"not_taken_meds"=>"Thinking about the last week. How often have you not taken your medicine?",
		"taken_meds_past_weekend"=>"Did you not take any of your medicine over the past weekend?", 
		"3months_days_not_taken_meds"=>"Over the past 3 months, how many days have you not taken any medicine at all?"
		];
		foreach ($questions as $key => $value) {  
			$xkey = $key;
			$yes = 'Yes';
			$no = 'No';
            if ($key == '3months_days_not_taken_meds') { // 3months_days_not_taken_meds
                $xkey = '_'.$key; // substr($key, 1);
                $options = [ "f-$xkey"=>'< 2days', "n-$xkey"=>'> 2days' ];
            } else if ($key == 'not_taken_meds')
                $options = [ 'f-not_taken_meds'=>'Never', 'n-not-taken-meds'=>'1-2', '3-not-taken-meds'=>'3-5', '5-not_taken_meds'=>'> 5' ];
            else
                $options = [ "f-$key"=>$yes, "n-$key"=>$no ];
            echo "<tr><td><h4>$value</h4></td>";
            foreach($options as $id => $choice) {
                eval("\$checked = (!empty (\$$xkey) and \$$xkey=='$choice')?'checked=\"checked\"':'';");
                echo "<td> 
    		    <div style=\"width:130px; float:left\" class=\"radio_sty\">
    			<input type=\"radio\" id=\"$id\" name=\"$key\" value=\"$choice\" $checked >
    			<label for=\"$id\">$choice</label>					
    			<div class=\"check\">
    			</div>
    		</div></td>";
            }
            echo '</tr>';
        }
?>
	</table>
</fieldset>
<fieldset>
	<h3>Laboratory Section <i>(compulsory)</i></h3>
	<table style="width:100%" border="0">
		<tbody>
			<tr>
				<td> <h4>Creatinine :</h4> </td>
				<td> <label><i>*mg/dl</i></label><input type="text" name="creatinine" value=""   /> </td>
			</tr>
			<tr>
				<td><h4>HepB Ag</h4></td>
				<td>
					<div style="width:120px; float:left" class="radio_sty">
						<input type="radio" id="f-hepbag"     name="hepbag" value="negative" required>
						<label for="f-hepbag">Neg</label>

						<div class="check">
						</div>
					</div>
					<div style="width:140px; float:left" class="radio_sty">
						<input type="radio" id="n-hepbag" name="hepbag" value="positive"  >
						<label for="n-hepbag">Pos</label>

						<div class="check">
						</div>
					</div> 
					<div style="width:220px; float:left" class="radio_sty">
						<input type="radio" id="3-hepbag"    name="hepbag" value="Not tested" >
						<label for="3-hepbag">Not tested</label>

						<div class="check">
						</div>
					</div>                           
				</td>                  
			</tr> 
			<tr>
				<td><h4> Hb:</h4> </td>
				<td> <label><i>*g/dl</i></label><input type="text" name="hb" value=""  />  </td>
			</tr>
			<tr>
				<td><h4> ALT: </h4></td>
				<td> <label><i>*U/l</i></label><input type="text" name="alt" value=""   /> </td>
			</tr>
			<tr>

				<td> <h4>Bilirubin: </h4></td>
				<td><label><i>*mg/dl</i></label> <input type="text" name="bilirubin" value=""   /> </td>

			</tr>   
		</tbody>
	</table>
</fieldset>
<hr />
<h3>Important Note:</h3>
<div class="text"> <p style="color:#f00">While this form is processed keep the patient on his current treatment regimen. It may still confer some benefit to be patient and resistance testing can only be done while patient is on treatment</p> </div>

<div class="form-actions">
	<div class="span3">
		<?php include ('includes/app_edit_first.php'); ?>
		<button class="btn" name="submit_patD" style="padding:10px; font-size:180%">Back</button>
    </div>
    <div class="span3">

    </div>
    
    <div class="span3">
    <button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_adher">Next</button> 
    </div>
    </div>
    
    </form>