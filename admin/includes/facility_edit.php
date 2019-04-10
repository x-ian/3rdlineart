<?php
global $facility_id;
$facility_id = $_GET['id'];
$facility=mysqli_query( $bd,"SELECT * FROM facility where id='$facility_id'"); 
$row_facility=mysqli_fetch_array($facility);
$facility_name =$row_facility['facilityName'];
$location =$row_facility['location'];
?>

<h2 style="background-color:#fff; text-align:left; color:#000000">Edit Facility</h2>
<hr />

<form id="edit-profile" class="form-horizontal" action="dash.php?update" method="post">
	<div class="control-group">											
		<label class="control-label" for="firstname">Facility Name</label>
		<div class="controls">							
			<input type="hidden" class="span3" id="id" name="id" value="<?php echo $facility_id; ?>" style="margin:5px" >
			<input type="text" class="span3" id="facilityName" name="facilityName" value="<?php echo $facility_name; ?>" style="margin:5px" >
		</div>			
	</div>

	<div class="control-group">											
		<label class="control-label" for="firstname">District</label>
		<div class="controls">
			<input type="text" class="span3" id="location" name="location" value="<?php echo $location; ?>" style="margin:5px" ><br />
		</div>			
	</div>

	<div class="form-actions">
		<div class="span2">
			<a href="dash.php?p" class="btn" style="padding:10px; font-size:180%">Cancel</a>
		</div>


		<div class="span2">
			<button type="submit" class="button btn btn-primary btn-large" style="padding:10px; font-size:180%" name="update_facility">Register</button>
		</div>
	</div>


</form>
