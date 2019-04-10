<form id="edit-profile" class="form-horizontal" action="app.php" method="post">

	<h2 style="background-color:#98a31a; text-align:center; color:#000000">6 Months Reminder</h2>
	<hr style=" border: 1px solid #cbe509;" />

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th> Id NoR </th>
				<th> 3rd Line switch start Date</th>
				<th> Remind</th>
			</tr>
		</thead>
		<tbody>
			<?php
			global $num_newforms; 
			$expert_review_consolidate2 = mysqli_query( $bd, "SELECT * FROM expert_review_consolidate2 ORDER BY `expert_review_consolidate2`.`id` DESC "); 
			$num_newforms = mysqli_num_rows ($expert_review_consolidate2);
			echo '<p>All reveiwed forms: [ <i>'. $num_newforms .'</i> ]</p>';

            $today = new DateTime();
			while ($row_expert_review_consolidate2=mysqli_fetch_array($expert_review_consolidate2)){

				$form_id = $row_expert_review_consolidate2['form_id'];
				$id = $row_expert_review_consolidate2['id'];
				$date_reviewed = $row_expert_review_consolidate2['consolidate2_date'];

                $rev_date = date_create_from_format('d/m/Y', $date_reviewed);
                $rev_date->modify('+26 week');
                $date_diff = $rev_date->diff($today);
                $days_remaining = $date_diff->format('%a Days Remaining');
                
				echo '
				<tr>
					<td> <p style="text-align:center"><a href="#"><strong> 3rdLForm#'. $form_id.'</strong></a></p> </td>
					<td> <p style="text-align:center"><strong>'. $date_reviewed.'</strong></p> </td>
					<td><p><b>'.$days_remaining.'.</p>

						<a href="#myModal" role="button" class="btn btn-warning"  data-toggle="modal" style="padding:6px; font-size:110%; position:relative; top:-5px;" >Send Reminder</a>
		<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 style="te
xt-align:center">Compose Reminder</h3>
				</div>
				<div class="modal-body"> 
					<form id="#" action="cp_p1.php?p&notcomplete&form_id='.$form_id.'" method="post">
						<p>To:'.$email.'</p>
						<input type="hidden" name="email_address" Value ="'.$email.'" />
						<h4>Compose Message</h4>
						<textarea style="width:93%" rows="8" name="comment" value="">
						</textarea>
						<div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;">
							<button type="submit" name="submit_reject" class="btn btn-warning" style="width:90%;height=80%">Patient Details</button>  
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				</div>
			</div>
						   
                     </td>
				 </tr> 

					<!-- Modal
					<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 style="text-align:center">Compose Reminder</h3>
						</div>
						<div class="modal-body"> 
                            <form>

                                <input type="text" name="subject" style="width:93%" />
                                <h4>Compose Message</h4>
                                <textarea style="width:93%" rows="12">

                                </textarea>
                            </form>

                            <div style="width:90%; background-color:#f2f2f2; border-radius: 5px; padding:5px; text-align:center; margin:5px;" >
                                <a href="#myModal" role="button" class="btn btn-warning"   data-toggle="modal" style="width:90%;" >Patient Details</a>
                            </div>
                        </div>
                    </div> -->
						';
					}
					?>


				</tbody>
			</table>