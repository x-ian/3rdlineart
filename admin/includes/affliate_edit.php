<?php
global $partner_org_id;
$partner_org_id = $_GET['id'];

$partner_org=mysqli_query( $bd,"SELECT * FROM partner_org where id ='$partner_org_id'"); 
$row_partner_org=mysqli_fetch_array($partner_org);
$partner_org_name =$row_partner_org['partner_org_name'];
?>
<h2 style="background-color:#fff; text-align:left; color:#000000">Edit Partner Org</h2>
<hr />


<form id="edit-profile" class="form-horizontal" action="dash.php?update" method="post">

	<div class="control-group">	
		<label class="control-label" for="firstname">Partner org name</label>
		<div class="controls">
			<input type="hidden" class="span3" id="id" name="id" value="<?php echo $partner_org_id; ?>" style="margin:5px" >
			<input type="text" class="span3" id="partner_org_name" name="partner_org_name" value="<?php echo $partner_org_name; ?>" style="margin:5px" >
		</div>
	</div>

	<div class="form-actions">
		<div class="span2">
			<a href="dash.php?p" class="btn" style="padding:10px; font-size:180%">Cancel</a>
		</div>
		<div class="span2">
			<button type="submit" class="button btn btn-primary btn-large" style="padding:10px; font-size:180%" name="update_affliate">Register</button>
		</div>
	</div>

</form>
