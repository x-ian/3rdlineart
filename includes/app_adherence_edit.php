<h2 style="background-color:#f8f7f7; text-align:center"> ART Adherence</h2>
<?php 
global $pat_id;
$pat_id= $_GET['pat_id'];

global $location;
// not sure why this switch is here!

$location = "complete_form.php";

$patient = new Patient($pat_id);
$client_name = $patient->fullname;

//adherence
$adherence = mysqli_query( $bd,"SELECT * FROM adherence where pat_id='$pat_id' "); 
$row_adherence = mysqli_fetch_array($adherence);

$scheduled_visit_date1 = $row_adherence['scheduled_visit_date1'];
$actual_visit_date1 = $row_adherence['actual_visit_date1'];
$pill_count1 = $row_adherence['pill_count1'];

$scheduled_visit_date2 = $row_adherence['scheduled_visit_date2'];
$actual_visit_date2 = $row_adherence['actual_visit_date2'];
$pill_count2 = $row_adherence['pill_count2'];

$scheduled_visit_date3 = $row_adherence['scheduled_visit_date3'];
$actual_visit_date3 = $row_adherence['actual_visit_date3'];
$pill_count3 = $row_adherence['pill_count3'];

//adherence_questions
$adherence_questions = mysqli_query( $bd,"SELECT * FROM adherence_questions where pat_id='$pat_id' "); 
$row_adherence_questions = mysqli_fetch_array($adherence_questions);

$ever_forget_2_take_meds = $row_adherence_questions['ever_forget_2_take_meds'];
$careless_taking_meds = $row_adherence_questions['careless_taking_meds'];
$stop_taking_meds = $row_adherence_questions['stop_taking_meds'];
$not_taken_meds = $row_adherence_questions['not_taken_meds'];
$taken_meds_past_weekend = $row_adherence_questions['taken_meds_past_weekend'];
$_3months_days_not_taken_meds = $row_adherence_questions['3months_days_not_taken_meds'];


//lab
$lab=mysqli_query( $bd,"SELECT * FROM lab where pat_id='$pat_id' "); 
$row_lab=mysqli_fetch_array($lab);

$creatinine = $row_lab['creatinine'];
$hb = $row_lab['hb'];
$alt = $row_lab['alt'];
$bilirubin = $row_lab['bilirubin'];
$hepbag = $row_lab['hepbag'];

// echo 'action="'.$location.'?pat_id='.$pat_id;
echo '
<form id="edit-profile" class="form-horizontal" action="'.$location.'?pat_id='.$pat_id.'" method="post" >';
	?> 

	<h3>Client Name: <strong><i style="color:red"><?php echo $client_name; ?></i></strong></h3>

	<input type="hidden" name="pat_id" value="<?php echo $pat_id; ?>"  /> 
	<input type="hidden" name="dob" value="<?php echo $dob; ?>" /> 
	<script>
	$(document).ready(function(){

       // prevents typing into date input box
        $('[id^="datepicker"]').keypress(function(e) {
            e.preventDefault();
        });

        var today = new Date();
        var epoch = new Date(1900, 1, 1);

        $( function() {
			$( "#datepickersVis_Date1" ).datepicker('option', {
				changeMonth: true,
                    yearRange: "1900:2018",                    
                    maxDate: today,
                    minDate: epoch,
                    dateFormat: 'dd/mm/yy',
                changeYear: true
			});
		} );


       $( function() {
			$( "#datepickeraVis_Date12" ).datepicker('option', {
				changeMonth: true,
                    yearRange: "1900:2018",
                    maxDate: today,                    
                    minDate: epoch,
                    dateFormat: 'dd/mm/yy',                    
				changeYear: true
			});
		} );

		$( function() {
			$( "#datepickersVis_Date2" ).datepicker('option', {
				changeMonth: true,
                    yearRange: "1900:2018",                    
                    maxDate: today,
                    // minDate: epoch,
                    dateFormat: 'dd/mm/yy',
				beforeShow : function()
				{
					// jQuery( this ).datepicker('option','minDate', jQuery('#datepickeraVis_Date12').val() );
				},
				changeYear: true
			});
		} );

		$( function() {
			$( "#datepickeraVis_Date22" ).datepicker('option', {
				changeMonth: true,
                    yearRange: "1900:2018",                    
                    maxDate: today,
                    // minDate: epoch,
                    dateFormat: 'dd/mm/yy',
				beforeShow : function()
				{
					jQuery( this ).datepicker('option','minDate', jQuery('#datepickeraVis_Date12').val() );
				},                    
				changeYear: true
			});
		} );

		$( function() {
			$( "#datepickersVis_Date3" ).datepicker('option', {
				changeMonth: true,
                    yearRange: "1900:2018",                    
                    maxDate: today,
                    // minDate: epoch,
                    dateFormat: 'dd/mm/yy',                    
				beforeShow : function()
				{
					jQuery( this ).datepicker('option','minDate', jQuery('#datepickeraVis_Date22').val() );
				},
				changeYear: true
			});
		} );

		$( function() {
			$( "#datepickeraVis_Date32" ).datepicker('option', {
				changeMonth: true,
                    yearRange: "1900:2018",                    
                    maxDate: today,
                    // minDate: epoch,
                    dateFormat: 'dd/mm/yy',                    
				beforeShow : function()
				{
					jQuery( this ).datepicker('option','minDate', jQuery('#datepickeraVis_Date22').val() );
				},
				changeYear: true
			});
		} );
    });
	</script> 

    <fieldset>
		<h2>Adherence Section <i>(Patient adherence in the last 3 visits)</i></h2>
		<table style="width:100%" border="0">
			<tbody>
				<?php     
				for($i=1; $i<=3; $i++) {
					eval("\$scheduled_visit_date = !empty ( \$scheduled_visit_date$i) ? \$scheduled_visit_date$i : '';");
					eval("\$actual_visit_date = !empty ( \$actual_visit_date$i) ? \$actual_visit_date$i : '';");
					eval("\$pill_count = !empty ( \$pill_count$i) ? \$pill_count$i : '';");
					// echo "date is ".$scheduled_visit_date;
                    
                    $svd = format_date_fromdb($scheduled_visit_date); // if I dont do this, the code doesn't work
                    $avd = format_date_fromdb($actual_visit_date);
                    echo "<tr>
                       <td> <h3>Schedule visit date:</h3><label><i>(dd/mm/yyyy)</i></label> </td>
                       <td> <input type=\"text\" name=\"scheduled_visit_date$i\" id=\"datepickersVis_Date$i\"  value=\"$svd\" required /> </td>

                       <td> <h3>Actual visit date </h3><label><i>(dd/mm/yyyy)</i></td>
                       <td> <input type=\"text\" name=\"actual_visit_date$i\" id=\"datepickeraVis_Date$i"."2\" value=\"$avd\" required /> </td>

                       <td> <h3>Pill Count (%) </h3> </td>
                       <td> <input type=\"number\" min=\"0\" max=\"104\" name=\"pill_count$i\" id=\"pill_count$i\" style=\"width:80px; height:50px;\"  value=\"$pill_count\" required/> </td>
                   </tr>";
                }
     ?>
</tbody>
</table>
</fieldset>
<hr style=" border: 1px solid #cbe509;" />
<fieldset>
	<h2>Adherence questions <i>(circle answer)</i></h2>
	
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
            echo "<tr><td style=\"width:500px; float:left\"><h3>$value</h3></td>";
            foreach($options as $id => $choice) {
                eval("\$checked = (!empty (\$$xkey) and \$$xkey=='$choice')?'checked=\"checked\"':'';");
                echo "<td> 
    		    <div style=\"width:130px; float:left\" class=\"radio-btn\">
    			<input type=\"radio\" id=\"$id\" name=\"$key\" value=\"$choice\" $checked required >
    			<label for=\"$id\">$choice</label>					
    			<div class=\"check\">
    			</div>
    		</div></td>";
            }
            echo '</tr><tr><td>&nbsp</td></tr>';
        }
?>
</table>
</fieldset>
<fieldset>
	<h2>Laboratory Section <i>(Please provide laboratory results if available)</i></h2>
	<table style="width:100%" border="0">
		<tbody>
			<tr>
				<td> <h3>Creatinine <i>*mg/dl</i>:</h3> </td>
				<td> <input type="text" name="creatinine" value="<?php
					if (!empty ( $creatinine)) { echo  $creatinine; } ?>" />
				</td>
			</tr>
			<tr>
				<td><h3>HepB Ag</h3></td>
				<td>
					<div style="width:120px; float:left" class="radio-btn">
						<input type="radio" id="f-hepbag" name="hepbag" value="negative"  <?php 
						if (!empty ($hepbag)) { if ($hepbag =='negative') { echo  'checked="checked"';} } ?>>
						<label for="f-hepbag">Neg</label>
						<div class="check">
						</div>
					</div>
					<div style="width:140px; float:left" class="radio-btn">
						<input type="radio" id="n-hepbag" name="hepbag" value="positive"  <?php 
						if (!empty ($hepbag)) { if ($hepbag =='positive') { echo  'checked="checked"';} } ?>>
						<label for="n-hepbag">Pos</label>
						<div class="check">
						</div>
					</div> 
					<div style="width:220px; float:left" class="radio-btn">
						<input type="radio" id="3-hepbag" name="hepbag" value="Not tested"  <?php 
						if (!empty ($hepbag)) { if ($hepbag =='Not tested') { echo  'checked="checked"';} } ?>>
						<label for="3-hepbag">Not tested</label>
						<div class="check">
						</div>
					</div>  

				</td>
			</tr>
			<tr>
            <td><h3> Hb <i>*g/dl</i>: </h3></td>
				<td> <input type="text" name="hb" value="<?php 
					if (!empty ($hb)) { echo $hb; } ?> "/>  
				</td>
			</tr>
			<tr>
				<td><h3> ALT <i>*U/l</i>: </h3></td>
				<td> <input type="text" name="alt" value="<?php 
					if (!empty ( $alt)) { echo  $alt; } ?> "/> 
				</td>
			</tr>
			<tr>	
				<td> <h3>Bilirubin <i>*mg/dl</i>: </h3></td>
				<td> <input type="text" name="bilirubin" value="<?php 
					if (!empty ($bilirubin)) { echo $bilirubin; } ?> "/> 
				</td>		
			</tr>   
		</tbody>
	</table>
</fieldset>
<hr />
<h2>Important Note:</h2>
<div class="text"> <p style="color:#f00; font-size:large;">While this form is processed keep the patient on their current treatment regimen. It may still confer some benefit to the patient and resistance testing can only be done while patient is on treatment</p> </div>

<div class="form-actions">
	<div class="span3">
		<a class="btn" href="app.php?back&back_adherence<?php echo '&pat_id='.$pat_id.'&g='.$patient->gender.'&xx='.$patient->age.'' ?>" style="padding:10px; font-size:180%">Back</a>                                                                                                                                      </div> 
		<div class="span3">
			<?php include ('includes/app_edit_menu.php'); ?>							
		</div>

		<div class="span3">
<?php
            if (isset($_POST['update_treatment3']) || isset($_GET['back_complete']))
                echo '<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="update_adher">Next</button>';
            else
                echo '<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_adher">Next</button>';
?>
		</div>
	</div>

</form>
