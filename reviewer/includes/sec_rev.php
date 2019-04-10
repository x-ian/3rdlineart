<form id="edit-profile" class="form-horizontal" action="#" method="post">
	<h2 style="background-color:#0eaff7; text-align:center; color:#000000">3rd Line Forms Under Review</h2>
	<hr style=" border: 1px solid #cbe509;" />
	<?php 
	global $num_forms;

	$assigned_forms=mysqli_query( $bd,"SELECT distinct form_id,date_assigned FROM assigned_forms WHERE form_id in (select form_id from reviewer_team_lead where reviewer_team_lead.rev_id=$rev_id) and form_id not in (select form_id from expert_review_consolidate1) ORDER BY `assigned_forms`.`form_id` DESC"); 
	$num_forms = mysqli_num_rows ($assigned_forms);
// echo '<p>Total forms: [ <i>'. $num_forms .'</i> ]</p>';
	?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th style="text-align:center"> <p><strong>Form Id</strong></p></th>
				<th style="text-align:center"> <p><strong>Date Assigned</strong></p></th>   
				<th class="td-actions" style="text-align:center"><p><strong>Reviewers</strong></p> </th>
				<th class="td-actions" style="text-align:center"><p><strong>Expert Reviews</strong></p> </th>
		</tr>
		</thead>
		<tbody>
			<?php

            $today = new DateTime();
            // echo 'today is '.$today->format('d/m/Y');

 			while ($row_assigned_forms=mysqli_fetch_array($assigned_forms)){
				$form_id = $row_assigned_forms['form_id'];
				$date_assigned = $row_assigned_forms['date_assigned'];
                // echo 'there '.$form_id.', date: '.$date_assigned;                
                $ass_date = date_create_from_format('d/m/Y', $date_assigned);                
                $ass_date->modify('1 week');
                $date_diff = $ass_date->diff($today);
                $remaining = $date_diff->format('%a Days Remaining');
                
                    // echo "<br>assigned: $date_assigned, ". $ass_date->format('d/m/Y').", diff:".$date_diff->format('%a days Remaining');
				echo '
				<tr>
					<td> <p style="text-align:center"><strong> 3rdlineForm #'.$form_id.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>'.$date_assigned.'</strong></p> </td>
					<td> <p style="text-align:center"><strong>
						';

                $assigned=mysqli_query( $bd,"SELECT rev_id, status FROM assigned_forms where form_id='$form_id'"); 
                $assigned_count=mysqli_query( $bd,"SELECT rev_id, status FROM assigned_forms where form_id='$form_id' and status ='Reviewed'");
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
								echo '
								<b style="color:#d00">'.$rev_fullname.'   ; </b>
								';
							} else {
								echo '<u style="color:#30af0a">'.$rev_fullname.';</u>';
							}
						}

						echo '</strong></p> </td>';      
						if ($complete_review >='3'){       
							echo ' 
							<td class="td-actions"><a href="review_p1.php?consolidate&formid='.$form_id.'" class="btn btn-large btn-success" style="color:#fff"><i class="btn-icon-only icon-ok"> Consolidate Reviews </i></a></td>
						</tr> 
						';
					}

					else {        
						echo ' <td class="td-actions">'.$remaining.'</td>';   
					}

				}
?>                
			</tbody>
		</table>