<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<a href="dash.php?create_drug" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a>
	<h2 style="background-color:#fff; text-align:center; color:#000000">Drugs</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <p style="text-align:center"><strong>Drug Id </strong></p></th>
				<th> <p style="text-align:center"><strong>Drug Name </strong></p></th>
				<th> <p style="text-align:center"><strong>Regimen Line </strong></p></th>

			</tr>
		</thead>
		<tbody>

			<?php
//clinic status info
			$drugs=mysqli_query( $bd,"SELECT * FROM drugs"); 

			while ($row_drugs=mysqli_fetch_array($drugs)){

				$drug_id =$row_drugs['id'];
				$drug_name =$row_drugs['drug_name'];
				$line =$row_drugs['line'];
				$description =$row_drugs['description'];

				echo '
				<tr>
					<td> <p style="text-align:center"><strong> Art#0'.$drug_id.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$drug_name.' </strong></p></td>
					<td> <p style="text-align:center"><strong>'.$line.' </strong></p></td>
					<td class="td-actions"><a href="dash.php?drug_edit&id='.$drug_id.'"> Edit </i></a></td>
					<td class="td-actions"><a href="dash.php?remove_x&page=man_drugs&id='.$drug_id.'" style="color:#f00" onclick ="return confirm (\'Are you sure you want to delete this drug?\')"> Remove </i></a></td>
				</tr> 

				';

			}

			?>


		</tbody>
	</table>