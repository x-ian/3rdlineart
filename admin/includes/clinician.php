<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<a href="dash.php?create_clin" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a>
	<h2 style="background-color:#fff; text-align:center; color:#000000">Registered Clinicians</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <p style="text-align:center"><strong>User Id </strong></p></th>
				<th> <p style="text-align:center"><strong>Fullname</strong></p></th>
				<th> <p style="text-align:center"><strong>ART Clinic </strong></p></th>
				<th> <p style="text-align:center"><strong>Email</strong></p></th>
				<th> <p style="text-align:center"><strong>Phone</strong></p></th>

			</tr>
		</thead>
		<tbody>
			<?php

			$clinician=mysqli_query($bd, "SELECT * FROM clinician ORDER BY lname"); 
			while ($row_clinician=mysqli_fetch_array($clinician)){

				$art_clinic =$row_clinician['art_clinic'];
				$clinician_name =$row_clinician['name'];
				$email =$row_clinician['email'];
				$phone =$row_clinician['phone'];
				$id =$row_clinician['id'];
				$user_id =$row_clinician['user_id'];

				$users=mysqli_query($bd, "SELECT * FROM users where id='$user_id'"); 
				$row_users=mysqli_fetch_array($users);
				$username =$row_users['username'];


				echo '
				<tr>
					<td> <p style="text-align:left"><strong> 3rdLClin#0'.$id.'</strong></p> </td>
					<td> <p style="text-align:left"><strong>'.$clinician_name.'</strong></p> </td>
					<td> <p style="text-align:left"><strong>'.$art_clinic.'</strong></p></td>

					<td><p style="text-align:left"><strong>'.$email.'</strong></p></td>
					<td><p style="text-align:left"><strong>'.$phone.'</strong></p> </td>
					<td class="td-actions"><a href="dash.php?clin_edit&id='.$id.'"> Edit </i></a></td>
					<td class="td-actions"><a href="dash.php?del_user&page=clin&id='.$user_id.'" style="color:#f00" onclick ="return confirm (\'Are you sure you want to delete?\')"> Remove </i></a></td>
				</tr> 		
				';
			}

			?>
		</tbody>
	</table>