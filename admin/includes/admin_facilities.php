<form id="edit-profile" class="form-horizontal" action="app.php" method="post">
	<a href="dash.php?create_facility" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a>
	<h2 style="background-color:#fff; text-align:center; color:#000000">Registered Facilities</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <p style="text-align:center"><strong>Facility Id </strong></p></th>
				<th> <p style="text-align:center"><strong>Facility Name </strong></p></th>
				<th> <p style="text-align:center"><strong>Location</strong></p></th>
			</tr>
		</thead>
		<tbody>
			<?php
//clinic status info

			$facility=mysqli_query( $bd,"SELECT * FROM facility"); 
			while ($row_facility=mysqli_fetch_array($facility)){
				$facility_id =$row_facility['id'];
				$facility_name =$row_facility['facilityName'];
				$location =$row_facility['location'];
				echo '
				<tr>
					<td> <p style="text-align:center"><strong> 3rdLFacility#0'.$facility_id.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$facility_name.' </strong></p></td>
					<td> <p style="text-align:center"><strong>'.$location.'</strong></p> </td>
					<td class="td-actions"><a href="dash.php?facility_edit&id='.$facility_id.'"> Edit </i></a></td>
					<td class="td-actions"><a href="dash.php?remove_x&page=man_facility&id='.$facility_id.'" style="color:#f00" onclick ="return confirm (\'Are you sure you want to delete? You should know what you are doing.\')"> Remove </i></a></td>
				</tr> 
				';
			}
			?>
		</tbody>
	</table>