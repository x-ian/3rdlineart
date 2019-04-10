 <form id="edit-profile" class="form-horizontal" action="app.php" method="post"> 

	<h2 style="background-color:#c77539; text-align:center; color:#000000">Lab Screen</h2>
	<hr style=" border: 1px solid #cbe509;" />
	<?php
	if(isset($_GET['received'])){
		$sampleid = $_GET ['3lfs'];

		$sql_sample = "UPDATE sample ".
		"SET status = 'Received'".
		"WHERE id = '$sampleid'" ;
// mysqli_select_db('3rdlineart_db');
		$sample_received = mysqli_query( $bd , $sql_sample);
        
		echo"<meta http-equiv=\"Refresh\" content=\"1; url=pih_p1.php?p\">";    
	}

// sample
	$sample=mysqli_query( $bd,"SELECT * FROM sample where status !='Dispatched'"); 
	$num_forms = mysqli_num_rows ($sample);
	echo '<p>Total forms: [ <i>'. $num_forms .'</i> ]</p>';
	echo '
	<table class="table table-grid table-bordered" border="4" cellspacing="10px">
		<thead>
			<tr>
				<th style="text-align:center"> <p><strong>FORM Id</strong></p></th>
				<th style="text-align:center"> <p><strong>Date Assigned</strong></p></th> 
				<th style="text-align:center"> <p><strong>Facility</strong></p></th> 
			</tr>
		</thead>           
		<tbody>
	   	';

			while ( $row_sample=mysqli_fetch_array($sample)) {
                
				$sample_id = $row_sample['id'];
				$form_id = $row_sample['form_id'];
				$clinician_id = $row_sample['clinician_id'];
				$status = $row_sample['status'];
				$date_created = $row_sample['date_created'];

				$clinician = mysqli_query( $bd,"SELECT * FROM clinician where id='$clinician_id'"); 
				$row_clinician= mysqli_fetch_array($clinician);
				$art_clinic = $row_clinician['art_clinic'];

				echo '
				<tr>
					<td border="4"> <p style="text-align:center"><strong><a href="#">Form # '. $form_id .'</a></strong></p>  </td>
					<td> <p style="text-align:center"><strong>'.$date_created.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'. $art_clinic .'</strong></p>  </td>
					';

					if($status =='Received') { 
						echo ' 
						<td class="td-actions"><a href="pih_p1.php?p&received&3lfs='.$sample_id .'" class="btn btn-small btn-revert" disabled="disabled"><i class="btn-icon-only icon-ok"> Sample Received </i></a></td>
						<td class="td-actions"><a href="pih_p1.php?formID='.$form_id.'&sample='.$sample_id .'" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> Enter Test Results </i></a></td>';   
					}

					else 
					{
						echo '
						<td class="td-actions"><a href="pih_p1.php?p&received&3lfs='.$sample_id .'" class="btn btn-small btn-warning"><i class="btn-icon-only icon-ok"> Sample Received </i></a></td>
						<td class="td-actions"><a href="javascript:;" class="btn btn-small btn-success" disabled="disabled"><i class="btn-icon-only icon-ok"> Repeat Test </i></a></td>';
					}

					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</form>
