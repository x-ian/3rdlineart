<form id="edit-profile" class="form-horizontal" action="#" method="post">

	<h2 style="background-color:#0eaff7; text-align:center; color:#000000">3rd Line Forms Under Review</h2>
	<hr style=" border: 1px solid #cbe509;" />
	<?php 
	global $num_forms;

	$assigned_forms=mysqli_query( $bd,"SELECT distinct form_id,date_assigned FROM assigned_app_results WHERE form_id in (select form_id from reviewer_team_lead2 where reviewer_team_lead2.rev_id=$rev_id) and form_id not in (select form_id from expert_review_consolidate2) ORDER BY `assigned_app_results`.`form_id` DESC"); 

	$num_forms = mysqli_num_rows ($assigned_forms);
	echo '<p>Total forms: [ <i>'. $num_forms .'</i> ]</p>';
	?>                         
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th style="text-align:center"> <p><strong>FORM Id</strong></p></th>
				<th style="text-align:center"> <p><strong>Date Assigned</strong></p></th>   
				<th class="td-actions" style="text-align:center"><p><strong>Reviewers</strong></p> </th>
				<th class="td-actions" style="text-align:center"><p><strong>Expert Reviews</strong></p> </th>
				
			</tr>
		</thead>
		<tbody>
			<?php

			while ($row_assigned_forms=mysqli_fetch_array($assigned_forms)){
				
				$form_id =$row_assigned_forms['form_id'];
				$date_assigned =$row_assigned_forms['date_assigned'];
				
				echo '
				<tr>
					<td> <p style="text-align:center"><strong> 3rdLForm#'.$form_id.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$date_assigned.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>
						';
						
						$assigned=mysqli_query( $bd,"SELECT rev_id, status FROM assigned_app_results where form_id='$form_id'"); 						
						$assigned_count=mysqli_query( $bd,"SELECT rev_id, status FROM assigned_app_results where form_id='$form_id' and status ='Reviewed'");						
						$complete_review = mysqli_num_rows ($assigned_count);
						
						$select_team_lead=mysqli_query( $bd,"SELECT * FROM reviewer_team_lead where form_id='$form_id'");
						$row_team_lead=mysqli_fetch_array($select_team_lead);
						
						$team_leader_id = $row_team_lead ['rev_id'];
						
						while ($row_assigned=mysqli_fetch_array($assigned)){
							
							$rev_id_as =$row_assigned['rev_id']; 
							$rev_status =$row_assigned['status']; 
							
							$select_reviewer=mysqli_query( $bd,"SELECT * FROM reviewer where id='$rev_id_as'"); 
							$row_select_reviewer=mysqli_fetch_array($select_reviewer);
							
							$rev_fname =$row_select_reviewer['fname']; 
							$rev_lname =$row_select_reviewer['lname']; 
							$rev_title =$row_select_reviewer['title']; 
							
							$rev_fullname = $rev_title.'.  '.$rev_fname.' '.$rev_lname;
							
							if ($rev_status=='Not Reviewed'){
								echo '<b style="color:#d00">'.$rev_fullname.'   ; </b>';
							}
							
							else {
								echo '<u style="color:#30af0a">'.$rev_fullname.' ; </u>';
							}
						}
						
						echo '</strong></p> </td>';
						
						if ($complete_review >= '3'){							
							echo ' 
							<td class="td-actions"><a href="review_p1.php?consolidate_result&formid='.$form_id.'" class="btn btn-large btn-success" style="color:#fff"><i class="btn-icon-only icon-ok"> Consolidate Reviews </i></a></td>
						</tr> 
						
						';
					}

					else {

						echo ' <td class="td-actions"> 2 Review days remaining   </td>';   
					}

				}


				?>


			</tbody>
		</table>