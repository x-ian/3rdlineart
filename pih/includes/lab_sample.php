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
if(isset($_GET['formID'])){
	$sampleid = $_GET ['sample'];
	$formid = $_GET ['formID'];
	$today = date ('d/m/Y');

    $patient = new Patient($formid, $id_type='form');
    /*
	$patient = mysqli_query( $bd,"SELECT * FROM patient,form_creation where patient.id=form_creation.patient_id and form_creation.3rdlineart_form_id='$formid' "); 
	$row_pat = mysqli_fetch_array($patient);
	$art_id_num = $row_pat['art_id_num'];
	$patientName = $row_pat['firstname'].' '.$row_pat['lastname'];
	$gender = $row_pat['gender'];
	$dob = $row_pat['dob'];
	$vl_sample_id = $row_pat['vl_sample_id'];
	$age = GetAge($dob);
    */
}

?>

<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<h2 style="background-color:#f8f7f7; text-align:center">Patient Details</h2>
	<hr style=" border: 1.5px solid #b49308;" />
	<table style="width:100%; background-color:#f7cf75; " border="0" cellpadding ="5">
		<tr>
			<td><p>Patient Name</p> 
			</td>
			<td>
				<h4> <?php echo $patient->fullname ?></h4>
			</td>    
			<td><p>Form#:</p>
			</td>    
			<td><span></span>
				<h4><?php echo $formid ?></h4>
			</td>    
		</tr> 
		<tr>
			<td>
				<p>ART-ID Number</p>
			</td>
			<td>
				<h4><?php echo $patient->art_id_num ?></h4>
			</td>    
			<td>
				<p>Gender</p>
			</td>    
			<td>
				<h4><?php echo $patient->gender ?></h4>
			</td>    
		</tr> 
		<tr>
			<td>
				<p>VL sample-ID</p>
			</td>
			<td>
				<h4><?php echo $patient->vl_sample_id ?></h4>
			</td>    
			<td>
				<p>Age</p>
			</td>    
			<td>
				<h4> <?php echo $patient->age ?></h4>
			</td>    
		</tr> 

	</table>




</form>

<?php
if(isset($_GET['vl_done'])){
	include ('includes/lab_vl_done.php'); 
}

else {

	?>
	<form id="edit-profile" class="form-horizontal" action="<?php echo 'pih_p1.php?formID='.$formid.'&sample='.$sampleid .'&vl_done' ?>" method="post" style="background-color:#ede9e9; padding:20px">

		<h2 style="background-color:#f5ec10; text-align:center">VL Repeat</h2>
		<hr style=" border: 1.5px solid #b49308;" />
		<h1><I>SampleID</I>: <span style="color:#f00"><?php echo $formid ?></span></h1>

		<script type="text/javascript">
    var today = new Date();
    var epoch = new Date(1900, 1, 1);
			jQuery(document).ready(function ($) {
				$('input[name="art_interrup"]').on('click', function () {
					if ($(this).val() === 'Yes') {
						$('#datepicker,#art_interupt_reason').prop("disabled", false);
					} else {
						$('#datepicker,#art_interupt_reason').prop("disabled", "disabled");
					}
				});
                
                $("#datepicker9").datepicker({
                  onSelect: function(dateText) {
                        // alert("Selected date: " + dateText + "; input's current value: " + this.value);
                        var alertdate = new Date(dateText);
                        // alert(alertdate.getDate()+':'+alertdate.getMonth());
                        alertdate.setDate(alertdate.getDate() + 21);
                        // alert('date+3wks: '+alertdate.getDate()+':'+alertdate.getMonth());
                        var datep3wks = alertdate.toLocaleDateString("en-US"); // (alertdate.getMonth()+1)+'/'+(alertdate.getDate())+'/'+alertdate.getFullYear();
                        // alert(datep3wks);
                        $('#datepicker11').val(datep3wks);
                    }
                });
			});

			$( function() {
				$( "#datepicker8" ).datepicker('option', {
                  maxDate: today,
                        minDate: epoch,
                        dateFormat: 'dd/mm/yy',
                        yearRange: '1900:20202020',                    
                        changeMonth: true,
                        changeYear: true
                        });
			} );

            $( function() {
				$( "#datepicker9" ).datepicker('option', {
                  maxDate: today,
                        minDate: epoch,
                        dateFormat: 'dd/mm/yy',
                        yearRange: '1900:20202020',                                        
                        changeMonth: true,
                        changeYear: true
                        });
			} );

            $( function() {  // dont think this is used anywhere....
				$( "#datepicker10" ).datepicker('option', {
                  maxDate: today,
                        minDate: epoch,
                        dateFormat: 'dd/mm/yy',
                        yearRange: '1900:20202020',                                                            
                        changeMonth: true,
                        changeYear: true
                        });
			} );

            $( function() {
				$( "#datepicker11" ).datepicker('option', {
                    // maxDate: today,
                        minDate: epoch,
                        dateFormat: 'dd/mm/yy',
                        yearRange: '1900:20202020',                                                                
                        changeMonth: true,
                        changeYear: true
				});
			} );

		</script>

		<div style="width:300px; float:left" class="radio_sty">
			<input type="radio" id="f-vl"    name="vl" value="Yes" required>
			<label for="f-vl">< 5000 Copies</label>

			<div class="check">
			</div>
		</div>
		<div style="width:300px; float:left" class="radio_sty">
			<input type="radio" id="n-vl" name="vl" value="No"  >
			<label for="n-vl">> 5000 Copies</label>

			<div class="check">
			</div>
		</div>
		<table style="width:100%" border="0" style="padding:100px">

			<tr class="no box">
				<td>
					<p><strong><span style="color:#f00">*</span> Sample Received Date</strong></p>
					<br />
				</td>

				<td>

					<input type="text" name="receive_date" value="<?php echo $today ?>" id="datepicker8" style="font-size:120%" readonly />
					<input type="hidden" name="sampleid" value="<?php echo $sampleid ?>" style="font-size:120%" />
					<br />

				</td>
				<td>
					<p><strong> <span style="color:#f00">*</span> Enter Results Dispatch date</strong></p>
					<br />
				</td>
				<td>

					<input type="text" name="dispatch_date" value="<?php echo $today ?>" id="datepicker9" style="font-size:120%" readonly />
					<br />

				</td>   
			</tr>
			<tr class="no box">
				<td>
					<p><strong> <span style="color:#f00">*</span> VL result (Current)</strong></p>
					<br />
				</td>
				<td>

					<input type="number" name="vl_result" style="font-size:120%" required />
					<br />

				</td> 
				<td>
					<p><strong> <span style="color:#f00">*</span> Expected Receive date at NHLS</strong></p>
					<br />
				</td>
				<td>

					<input type="text" name="nhls_receive_date" id="datepicker11" style="font-size:120%" readonly />
					<br />

				</td>   
			</tr>

		</table>
		<h4>Result</h4>

		<p>* VL repeated and if  "> 5000" the sample should be shipped to NHLS. </p>
		<p>* VL repeated and if  " 5000" SEND message to 3rd line sectretary. </p>

        <div class="form-actions">
			<div class="span3">
				<button class="btn" style="padding:10px; font-size:180%"><a href="pih_p1.php?p">Cancel</a></button>
            </div>
            <div class="span3">
            </div>
            <div class="span3">
            <button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_vl_done">VL Done</button> 
            </div>
		</div>
		</form>        
		<?php 
	}

	?>
