<?php
if(isset($_GET['show_app_form'])){
    // echo 'show form here!';
    include ('includes/app_form.php');
}
?>
<form id="edit-profile" class="form-horizontal" action="app.php" method="post">
	<h2 style="background-color:#e1f408; text-align:center; color:#000000">Reviewed Applications</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> Form ID </th>
                <th> Reviewers </th>
				<th> Date referral received</th>
			</tr>
		</thead>
		<tbody>
			<?php
			global $num_newforms;
            $expert_review_consolidate1 = mysqli_query( $bd, $cp_query['select_expert_review_consolidate1'] );
			$num_newforms = mysqli_num_rows ($expert_review_consolidate1);
            // echo '<p>All reviewed forms: [ <i>'. $num_newforms .'</i> ]</p>';
			while ($row_expert_review_consolidate1 = mysqli_fetch_array($expert_review_consolidate1)){

				$form_id = $row_expert_review_consolidate1['form_id'];
				$id = $row_expert_review_consolidate1['id'];
				$date_reviewed = $row_expert_review_consolidate1['date_reviewed'];

                // get form info for display
                $forms = mysqli_query( $bd, "SELECT * FROM form_creation WHERE 3rdlineart_form_id = $form_id");
                $form = mysqli_fetch_array($forms);
                $app = new Application($form_id);
                
                $patient_id = $form['patient_id'];
                $clinician_id = $form['clinician_id'];
                echo '
				<tr>
					<td> <strong> 3rdLForm#'.$form_id.'</strong> </td>
                    <td style="width:30%">'.$row_expert_review_consolidate1['reviewer_names'].'</td>
					<td> <p style="text-align:center"><strong>'.$date_reviewed.'</strong></p> </td>
<td class="td-actions"><div style="text-align:center"> <a href="cp_p1.php?view&subnav=reviewed_app&id='.$form_id.'&clin_id='. $clinician_id.'&pat_id='.$patient_id.'" class="btn btn-small btn-warning"><i class="btn-icon-only icon-ok">View</i></a></div></td>
				</tr> 

				';
			}
			?>
		</tbody>
	</table>


