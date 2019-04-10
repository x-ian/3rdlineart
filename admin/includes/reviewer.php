<a href="dash.php?reviewer" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a>
<h2 style="background-color:#fff; text-align:center; color:#000000">Registered Reviewers</h2>
<hr style=" border: 1px solid #cbe509;" />

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th> <p style="text-align:center"><strong>User Id </strong></p></th>
			<th> <p style="text-align:center"><strong>Name </strong></p></th>
			<th> <p style="text-align:center"><strong>Org</strong></p></th>
			<th> <p style="text-align:center"><strong>Email</strong></p></th>
			<th> <p style="text-align:center"><strong>Phone</strong></p></th>
			<th> <p style="text-align:center"><strong>About</strong></p></th>
		</tr>
	</thead>
	<tbody>
		<?php

		$reviewer=mysqli_query( $bd,"SELECT * FROM reviewer where linked <> 1"); 
		while ($row_reviewer=mysqli_fetch_array($reviewer)){
			
			$title = $row_reviewer['title'];
			$fname = $row_reviewer['fname'];
			$lname = $row_reviewer['lname'];
			$email = $row_reviewer['email'];
			$phone = $row_reviewer['phone'];
			$affiliate_institution = $row_reviewer['affiliate_institution'];
			$snapshot = $row_reviewer['snapshot'];
			$rev_id = $row_reviewer['id'];
			$user_id = $row_reviewer['user_id'];
			
			$users=mysqli_query( $bd,"SELECT * FROM users where id='$user_id'"); 
			$row_users=mysqli_fetch_array($users);
			$username = $row_users['username'];
			$role = $row_users['role'];
			
			$revfullname = $fname .'  '. $lname;
			
			echo '
			<tr>
				<td> <p style="text-align:center"><strong> 3rdLRev#0'.$rev_id.'</strong></p> </td>
				<td> <p style="text-align:center"><strong>'.$revfullname.' </strong></p></td>
				<td> <p style="text-align:center"><strong>'.$affiliate_institution.'</strong></p> </td>
				<td> <p style="text-align:center"><strong>'.$email.'</strong></p> </td>
				<td> <p style="text-align:center"><strong>'.$phone.'</strong></p> </td>
				<td> <p style="text-align:center"><strong>'.$snapshot.'</strong></p> </td>
				<td class="td-actions"><a href="dash.php?rev_edit&id='.$rev_id.'"> Edit </i></a></td>
				<td class="td-actions"><a href="dash.php?del_user&page=man_rev&id='.$user_id.'" style="color:#f00" onclick ="return confirm (\'Are you sure you want to delete?\')"> Remove </i></a></td>
			</tr> 
			
			';
			
		}


		?>

		
	</tbody>
</table>