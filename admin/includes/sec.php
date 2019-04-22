<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<a href="dash.php?create_sec" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a>
	<h2 style="background-color:#fff; text-align:center; color:#000000">Registered Data Clerk (Sec)</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <p style="text-align:center"><strong>User Id </strong></p></th>
				<th> <p style="text-align:center"><strong>Secretary Name </strong></p></th>
				<th> <p style="text-align:center"><strong>Email</strong></p></th>
				<th> <p style="text-align:center"><strong>Phone</strong></p></th>

			</tr>
		</thead>
		<tbody>
			<?php

			$secretary=mysqli_query($bd, "SELECT * FROM secretary"); 
			while ($row_secretary=mysqli_fetch_array($secretary)){

				$fname =$row_secretary['fname'];
				$lname =$row_secretary['lname'];
				$phone =$row_secretary['phone'];
				$email =$row_secretary['email'];
				$id =$row_secretary['id'];
				$user_id =$row_secretary['user_id'];
				$users=mysqli_query($bd, "SELECT * FROM users where id='$user_id'"); 
				$row_users=mysqli_fetch_array($users);
				$username =$row_users['username'];
				$secfullname = $fname .'  '. $lname;

				echo '
				<tr>
					<td> <p style="text-align:center"><strong> 3rdLSec#0'.$id.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$secfullname.' </strong></p></td>
					<td> <p style="text-align:center"><strong>'.$email.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$phone.'</strong></p></td>
					<td class="td-actions"><a href="dash.php?sec_edit&id='.$id.'"> Edit </i></a></td>
					<td class="td-actions"><a href="dash.php?del_user&page=sec&id='.$user_id.'" style="color:#f00"> Remove </i></a></td>
				</tr> 

				';

			}


			?>


		</tbody>
	</table>