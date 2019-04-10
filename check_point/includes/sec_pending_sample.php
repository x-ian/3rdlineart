<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<h2 style="background-color:#e1f408; text-align:center; color:#000000">Reviewed Applications & Pending Samples</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> Id NoR </th>
				<th> Date referral received</th>
			</tr>
		</thead>
		<tbody>
			<?php
			global $num_newforms; 
            $expert_review_consolidate1=mysqli_query( $bd, $cp_query['select_sec_pending_sample']); 
			$num_newforms = mysqli_num_rows ($expert_review_consolidate1);
            // echo '<p>All reveiwed forms: [ <i>'. $num_newforms .'</i> ]</p>';
			while ($row_expert_review_consolidate1=mysqli_fetch_array($expert_review_consolidate1)){

				$form_id =$row_expert_review_consolidate1['form_id'];
				$id =$row_expert_review_consolidate1['id'];
				$date_reviewed =$row_expert_review_consolidate1['date_reviewed'];

				echo '
				<tr>
					<td> <p style="text-align:center"><a href="#"><strong> 3rdLForm#'. $form_id.'</strong></a></p> </td>
					<td> <p style="text-align:center"><strong>'.$date_reviewed.'</strong></p> </td>
				</tr> 

				';
			}
			?>
		</tbody>
	</table>