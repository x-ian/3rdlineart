<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<a href="dash.php?create_lab_user" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a>
	<h2 style="background-color:#fff; text-align:center; color:#000000">Registered Lab Staff</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <p style="text-align:center"><strong>User Id </strong></p></th>
				<th> <p style="text-align:center"><strong>Lab Manager</strong></p></th>
				<th> <p style="text-align:center"><strong>Email</strong></p></th>
				<th> <p style="text-align:center"><strong>Phone</strong></p></th>
				<th> <p style="text-align:center"><strong>Address</strong></p></th>     
			</tr>
		</thead>
		<tbody>
			<?php

			$pih_lab=mysqli_query($bd, "SELECT * FROM pih_lab"); 
			while ($row_pih_lab=mysqli_fetch_array($pih_lab)){

				$fname = $row_pih_lab['fname'];
				$lname = $row_pih_lab['lname'];
				$email = $row_pih_lab['email'];
				$phone = $row_pih_lab['phone'];
				$address = $row_pih_lab['address'];                
				$id = $row_pih_lab['id'];
				$user_id = $row_pih_lab['user_id'];

				$users=mysqli_query($bd, "SELECT * FROM users where id='$user_id'"); 
				$row_users=mysqli_fetch_array($users);
				$username = $row_users['username'];
				$stafffullname = $fname .'  '. $lname;

				echo '
				<tr>
					<td> <p style="text-align:center"><strong> 3rdLLab#0'.$id.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$stafffullname.' </strong></p></td>
					<td> <p style="text-align:center"><strong>'.$email.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$phone.'</strong></p></td>
					<td> <p style="text-align:center"><strong>'.$address.'</strong></p></td>
					<td class="td-actions"><a href="dash.php?lab_edit&id='.$id.'"> Edit </i></a></td>
	                <td class="td-actions"><a href="dash.php?del_user&page=lab&id='.$user_id.'" style="color:#f00" onclick ="return confirm (\'Are you sure you want to delete?\')"> Remove </i></a></td>
					<!-- <td class="td-actions"><a href="dash.php?lab_remove&id='.$id.'" style="color:#f00"> Remove </i></a></td> -->
				</tr> 
				';		
			}
			?>
		</tbody>
	</table>