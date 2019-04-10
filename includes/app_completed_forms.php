<form id="edit-profile" class="form-horizontal" action="app.php" method="post">
	<!-- <a href="dash.php?edit_app" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a> -->
	<h2 style="background-color:#fff; text-align:center; color:#000000">Patient Applications</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <p style="text-align:center"><strong>User Id </strong></p></th>
				<th> <p style="text-align:center"><strong>Fullname</strong></p></th>
				<th> <p style="text-align:center"><strong>ART ID #</strong></p></th>
				<th> <p style="text-align:center"><strong>Gender</strong></p></th>
				<th> <p style="text-align:center"><strong>DOB</strong></p></th>
                <th> <p style="text-align:center"><strong>Status</strong></p></th>     
			</tr>
		</thead>
		<tbody>
			<?php
            $patient = mysqli_query( $bd, "SELECT * FROM patient, form_creation WHERE patient.id = form_creation.patient_id and form_creation.clinician_id='$clinicianID'");
            while ($row_patient=mysqli_fetch_array($patient)){

				$id = $row_patient['id'];                
				$art_id_num = decrypt($row_patient['art_id_num'], $enckey);
				$patient_name = decrypt($row_patient['firstname'], $enckey).' '.decrypt($row_patient['lastname'], $enckey);
				$gender = $row_patient['gender'];
				$dob = $row_patient['dob'];
                $status = $row_patient['status'];
                
				echo '
				<tr>
					<td> <p style="text-align:left"><strong> 3rdLPat#0'.$id.'</strong></p> </td>
					<td> <p style="text-align:left"><strong>'.$patient_name.'</strong></p> </td>
					<td> <p style="text-align:left"><strong>'.$art_id_num.'</strong></p> </td>
					<td> <p style="text-align:left"><strong>'.$gender.'</strong></p> </td>
					<td> <p style="text-align:left"><strong>'.$dob.'</strong></p> </td>
					<td> <p style="text-align:left"><strong>'.$status.'</strong></p> </td>
					<!-- <td class="td-actions"><a href="dash.php?edit_app&pat_id='.$id.'"> Edit </i></a></td>
					<td class="td-actions"><a href="dash.php?del_user&page=clin&pat_id='.$user_id.'" style="color:#f00" onclick ="return confirm (\'Are you sure you want to delete?\')"> Remove </i></a></td> -->
				</tr> 		
				';
			}
			?>
		</tbody>
	</table>
