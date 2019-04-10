<script type="text/javascript">
	$().ready(function() {
		// validate the comment form when it is submitted
		$('body').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				$('input[type="submit"]:last').click();
			}
		});

        $(function() {
            $( "#datepicker1" ).datepicker();
        });

		// validate signup form on keyup and submit
		$("#edit-profile").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				art_id_num: {
					required: true,
					minlength: 7
				},
				art_clinic: {
					required: true,
					
				},
				gender: {
					required: true,
					
				},
                required: All
                    },
			messages: {
				firstname: "Please enter Client's firstname",
				lastname: "Please enter Client's lastname",
				art_id_num: {
					required: "Please enter ART Number",
					minlength: "The ART Number must consist of at least 7 characters"					
				},
				art_clinic: {
					required: "Please Select Patient's ART Clinic"
				},
				gender: {
					required: "Please Select Gender"
				},
                required: "required"                    
			}
		});

		// propose username by combining first- and lastname
        /*
		$("#username").focus(function() {
			var firstname = $("#firstname").val();
			var lastname = $("#lastname").val();
			if (firstname && lastname && !this.value) {
				this.value = firstname + "." + lastname;
			}
		});
        */
	});

</script>
<?php
global $key;
// echo "id".$clinicianID;
// echo "<br>key: $key";
?>
<table style="width:100%; background-color:#f8f7f7;  " >
	<tr><td>
		<form id="search_art" action="app.php" method="post" style="float:right; padding:10px; height:20px;">
			<select name="id" id="id">
				<option value="">--select ARV Number--</option>
				<?php

				global $num_newforms; 
				$form_creation=mysqli_query( $bd,"SELECT * FROM form_creation where (status='Not Complete' or complete ='Rejected') and clinician_id='$clinicianID' ORDER BY `form_creation`.`3rdlineart_form_id` DESC "); 
				$num_newforms = mysqli_num_rows ($form_creation);
				while ($row_form_creation = mysqli_fetch_array($form_creation)){      
					$patient_id = $row_form_creation['patient_id'];

                    $patient = new Patient($patient_id);
					echo '<option value= "'.$patient_id.'">'.$patient->art_id_num.'</a></option>';
				}
				?>
			</select>
			<button type="submit" name="search" class="btn btn-primary" style="padding:6px; font-size:110%; position:relative; top:-5px; color:#fff">Complete Application</button>
		</form>
	</td></tr>
</table>
</form>
<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<h2 style="background-color:#f8f7f7; text-align:center">New Patient Details</h2>
	<hr style=" border: 1.5px solid #b49308;" />

	<table style="width:100%" border="0">
		<tr>
			<td>
				<h4>ART Clinic</h4> 
			</td>
			<td>
				<select name="pat_art_clinic" required id="art_clinic">
					<option selected="selected" value="">select ART Clinic</option>
					<?php
					// clinic status info
					$facility=mysqli_query( $bd,"SELECT * FROM facility"); 
					while ($row_facility=mysqli_fetch_array($facility)){						
						$facility_name =$row_facility['facilityName'];
						echo '<option>'.$facility_name.'</option>';
					}
					?>
				</select>
			</td>
		</tr>
	</table>
	<hr >

	<table style="width:100%" border="0">
		<tr>
			<td><h4>First Name</h4> 
			</td>
			<td>
				<input type="text" class="span4" id="firstname" name="firstname" required>
			</td>    
			<td><h4>Surname</h4> 									
			</td>    
			<td>											
				<input type="text" class="span4" id="lastname" name="lastname" required >
			</td>    
		</tr> 
		<tr>
			<td>
				<h4>ART-ID Number</h4>
			</td>
			<td>
				<input type="text" class="span4" id="art_id_num" value="" name="art_id_num" required>
			</td>    
			<td>
				<h4>Gender</h4>
			</td>    
			<td>
				<select name="gender" required id="gender" >
					<option selected="selected" value="">select gender</option>
					<option>Male</option>
					<option>Female</option>
				</select>
			</td>    
		</tr> 
		<tr>
			<td>
				<h4>Last VL sample-ID</h4><label><i>(optional)</i></label>
			</td>
			<td>
				<input type="text" class="span4" id="vl_sample_id" value="" name="vl_sample_id">
			</td>    
			<td>
				<h4>Date of Birth</h4><label><i>(dd/mm/yyyy)</i></label>
			</td>    
			<td>
				<input type="text" class="span4" name="dob" id="datepicker1" readonly="true">
				<p id="error"></p>
			</td>    
		</tr> 

	</table>

	<div class="form-actions">
		<div class="span3">
			<a class="btn" href="app.php?p" style="padding:10px; font-size:180%">Back</a>
		</div>
		<div class="span3">
		</div>

		<div class="span3">
			<?php 
			if(isset($_GET['back'])){
				echo '<button type="submit" class="btn btn-success" style="padding:10px; font-size:180%" name="update_patD">Update</button> ';
			}
			else {
				echo '<button type="submit" id="next" class="btn btn-success" style="padding:10px; font-size:180%" name="submit_patD">Next</button> '; }
				?>    
			</div>
		</div>
	</form>
