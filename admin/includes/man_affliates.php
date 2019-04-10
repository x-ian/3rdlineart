<form id="edit-profile" class="form-horizontal" action="app.php" method="post">
	
	<a href="dash.php?create_affliate" class="btn btn-small btn-success" style="padding:5px; font-size:120%; float:right"> Create New </a>
	<h2 style="background-color:#fff; text-align:center; color:#000000">Registered Partners</h2>
	<hr style=" border: 1px solid #cbe509;" />
	
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> <p style="text-align:center"><strong>Partner Id </strong></p></th>
				<th> <p style="text-align:center"><strong>Org Name </strong></p></th>
				
				
			</tr>
		</thead>
		<tbody>
			

			<?php
//clinic status info

			$partner_org=mysqli_query( $bd,"SELECT * FROM partner_org"); 

			while ($row_partner_org=mysqli_fetch_array($partner_org)){
				
				$partner_org_id =$row_partner_org['id'];
				$partner_org_name =$row_partner_org['partner_org_name'];
				
				echo '
				<tr>
					<td> <p style="text-align:center"><strong> 3rdLPartner#0'.$partner_org_id.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$partner_org_name.' </strong></p></td>
					<td class="td-actions"><a href="dash.php?affliate_edit&id='.$partner_org_id.'"> Edit </i></a></td>
					<td class="td-actions"><a href="dash.php?remove_x&page=man_affliates&id='.$partner_org_id.'" style="color:#f00" onclick ="return confirm (\'Are you sure you want to delete?\')"> Remove </i></a></td>
				</tr> 
				
				';
				
			}


			?>

			
		</tbody>
	</table>