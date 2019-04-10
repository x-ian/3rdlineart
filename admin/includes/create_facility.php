<h2 style="background-color:#fff; text-align:left; color:#000000">New Facility</h2>
<hr/>

<script type="text/javascript">
	$(document).ready(function(){
		$('select').click(function(){
            alert('got one: '+$('select').val());
            $('#facilityName').val($('select').val());
        });
    });
</script>

<form id="edit-profile" class="form-horizontal" action="dash.php" method="post">

	<div class="control-group">
     <label class="control-label" for="facility">Choose Facility to Register</label>     
<?php
     $facility_query = "SELECT * FROM facilitys where ftype like '%Hospital' order by name";
$facility_result = mysqli_query( $bd, $facility_query );
echo '<div class="controls"><select name="facilty" id="facility" class="span3">';
while ($row_facility = mysqli_fetch_array($facility_result)) {
    $facility = $row_facility['name'];
    echo "<option value=\"$facility\">$facility</option>";
}
?>
</select>
</div>
</div>

	<div class="control-group">											
		<label class="control-label" for="firstname">Facility Name</label>
		<div class="controls">							
			<input type="text" class="span3" id="facilityName" name="facilityName" style="margin:5px" >
		</div>			
	</div>

	<div class="control-group">											
		<label class="control-label" for="firstname">Address</label>
		<div class="controls">
			<input type="text" class="span3" id="location" name="location" style="margin:5px" ><br />
		</div>			
	</div>

     
	
	<div class="form-actions">
		<div class="span2">
			<a href="dash.php?p" class="button btn btn-large" style="padding:10px; font-size:180%">Cancel</a>
		</div>
		
		<div class="span2">
			<button type="submit" class="button btn btn-primary btn-large" style="padding:10px; font-size:180%" name="register_facility">Register</button>
		</div>
	</div>
		
</form>

