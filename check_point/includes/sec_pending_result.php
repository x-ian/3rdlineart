<form id="edit-profile" class="form-horizontal" action="app.php" method="post">
     <h2 style="background-color:#8985f0; text-align:center; color:#000000">Pending NHLS Result</h2>
     <hr style=" border: 1px solid #cbe509;" />
     
     <table class="table table-striped table-bordered">
     <thead>
			<tr>
				<th> <p style="text-align:center"><strong>Id NoR</strong></p> </th>
				<th> <p style="text-align:center"><strong>Client BIO</strong></p></th>
				<th> <p style="text-align:center"><strong>Date Sample Dispatched</strong></p></th>
				<th> <p style="text-align:center"><strong>Expected Result Date</strong></p></th>
				<th class="td-actions"> </th>
			</tr>
		</thead>
		<tbody>
			<?php
			global $num_forms;

            $form_creation=mysqli_query( $bd, $cp_query['select_sec_pending_results']); 
			$num_forms = mysqli_num_rows ($form_creation);
			echo '<p>Total forms: [ <i>'. $num_forms .'</i> ]</p>';

			while ($row_form_creation=mysqli_fetch_array($form_creation)){

				$_3rdlineart_form_id =$row_form_creation['3rdlineart_form_id'];
				$clinician_id =$row_form_creation['clinician_id'];
				$patient_id =$row_form_creation['patient_id'];
				$dispatch_date =$row_form_creation['dispatch_date'];
				$nhls_receive_date =$row_form_creation['nhls_receive_date'];
				$status =$row_form_creation['status'];
				$date_created =$row_form_creation['date_created'];

				$SQL_clinician = "SELECT * FROM clinician WHERE id=$clinician_id";
				$clinician = mysqli_query($bd,$SQL_clinician);
				$row_clinician = mysqli_fetch_array($clinician);
				$art_clinic = $row_clinician['art_clinic'];

                $patient = new Patient($patient_id);
                $patient_name = $patient->fullname;
                
				echo '
				<tr>
					<td> <p style="text-align:center"><a href="cp_p1.php?assign&id='.$_3rdlineart_form_id.'"><strong> 3rdLForm#'.$_3rdlineart_form_id.'</strong></a></p> </td>
					<td> 
						<p style="text-align:left"><strong>Name: '. $patient_name.'</strong></p> 
						<p style="text-align:left"><strong>DOB: '. $patient->dob.'</strong></p> 
						<p style="text-align:left"><strong>Gender: '. $patient->gender.'</strong></p> 

					</td>
					<td> <p style="text-align:center"><strong>'.$dispatch_date.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$nhls_receive_date.'</strong></p> </td>
					<td class="td-actions"><a href="cp_p1.php?received&id='.$_3rdlineart_form_id.'" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> Result Received </i></a></td>
				</tr> 

				';

			}

			?>

		</tbody>
	</table>