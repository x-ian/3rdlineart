<?php
$all_reviews = true;
if ($all_reviews and !$no_output)
    $expert_review_form=mysqli_query( $bd,"SELECT * FROM expert_review_form where form_id ='$formID'");
else
    $expert_review_form=mysqli_query( $bd,"SELECT * FROM expert_review_form where form_id ='$formID' and rev_id = '$rev_id' ");

if ($all_reviews and !$no_output)
    echo '<table style="width:95%; align:center"><tr>';
while ($row_expert_review_form=mysqli_fetch_array($expert_review_form)){
    if (!$no_output)
        echo '<td style="width:33%">';
	$this_rev_id = $row_expert_review_form['rev_id'];
	$genotyping = $row_expert_review_form['genotyping'];
	$comment_to_clinician = $row_expert_review_form['comment_to_clinician'];
	$date_reviewed = $row_expert_review_form['date_reviewed'];

	$select_reviewer = mysqli_query( $bd,"SELECT * FROM reviewer where id='$this_rev_id'"); 
	$row_select_reviewer = mysqli_fetch_array($select_reviewer);

	$rev_fname = $row_select_reviewer['fname']; 
	$rev_lname = $row_select_reviewer['lname']; 
	$rev_title = $row_select_reviewer['title']; 
	$rev_fullname = $rev_title.'.  '.$rev_fname.' '.$rev_lname;

    if (!$no_output) {
        echo ' 
	<table class="table table-striped table-bordered" title='.(($rev_id == $this_rev_id) ? "My Review" : "$rev_fullname's Review").'>
		<th><h4>'.(($rev_id == $this_rev_id) ? "My Review" : "$rev_fullname's Review").'<br>from: <strong><u> '.$date_reviewed.'</u></strong></h4></th>
		<tr><td><p style="font-size: 12pt;">Genotyping: <b>'.$genotyping.'</b></p>
			<h4>Comment</h4>
			<p style="font-size: 12pt;">
				'.$comment_to_clinician.'
			</p>
		</td></tr>';
        if (!$no_output)
            echo '
	</table>
</td>
	';
    }
}
 if (!$no_output and $all_reviews)
     echo '</tr>
</table>';
?>
