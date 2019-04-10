<form id="edit-profile" class="form-horizontal" action="app.php" method="post">						 
<h2 style="background-color:#e1f408; text-align:center; color:#000000">Reviewed Applications</h2>
                        <hr style=" border: 1px solid #cbe509;" />                   
<?php    
global $num_forms;
if ($all_forms)
    $form_my_reviews = mysqli_query( $bd,"SELECT distinct (form_id),date_assigned FROM assigned_forms where status ='Reviewed'");
else
    $form_my_reviews = mysqli_query( $bd,"SELECT * FROM assigned_forms where rev_id='$rev_id' and status ='Reviewed'");
$num_forms = mysqli_num_rows ($form_my_reviews);

// echo '<p>Total forms: [ <i>'. $num_forms .'</i> ]</p>';
?>

<table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="text-align:center"> <p><strong>FORM Id</strong></p></th>
                    <th style="text-align:center"> <p><strong>Date Assigned</strong></p></th>
<?php echo $all_forms ? '' : '<th style="text-align:center"> <p><strong>My Review</strong></p></th>' ?>
                    <th style="text-align:center"> <p><strong>Other Reviewers</strong></p></th>        
                    <th style="text-align:center"> <p><strong>Consolidated</strong></p></th>
                    <th syle="text-align:center"> <p><strong>Genotype?</strong></p></th>
                    <th class="td-actions"> </th>
                  </tr>
                </thead>
                <tbody>
                 <?php

    while($row_form_creation=mysqli_fetch_array($form_my_reviews)){
        $formID = $form_id = $row_form_creation['form_id'];
        // $sec_id = $row_form_creation['sec_id'];
        // $status = $row_form_creation['status'];
        $date_assigned = $row_form_creation['date_assigned'];        
        $consolidated = mysqli_query($bd, "SELECT * FROM expert_review_consolidate1 WHERE form_id = '$form_id'");

        $app = new Application($form_id);

        $no_output = true;
        include ("includes/my_review.php");
        $mycomment = "<span style\"font-weight:bold;\">Genotyping:</span> $genotyping<br><span style=\"font-weight:bold;\">Comment:</span> $comment_to_clinician";
        
        if ($row_consolidated = mysqli_fetch_array($consolidated)) {
            $isconsolidated = 'Yes';
            $genotyping_cons = $row_consolidated['genotyping'];
        } else {
            $isconsolidated = 'No';
            $genotyping_cons = 'N/A';            
        }
        echo '
            <tr>
            <td> <div style="text-align:left;font-weight:bold;">3rdLForm#'.$form_id.'</div> </td>
            <td> <div style="text-align:left;font-weight:bold;">'.$date_assigned.'</div></td>';
        echo $all_forms ? '' : '<td> <div style="text-align:center;font-weight:bold;">'. $mycomment . '</div></td>';
        echo '<td>'.$app->other_reviewers($all_forms ? 0 : $rev_id).'</td>
        <td> <div style="text-align:center;font-weight:bold;">'. $isconsolidated . '</div></td>
        <td> <div style="text-align:center;font-weight:bold;">'. $genotyping_cons . '</div></td>
        <td class="td-actions"><div style="text-align:center"> <a href="review_p1.php?review&id='.$form_id.'&reviewed=1" class="btn btn-small btn-warning"><i class="btn-icon-only icon-ok">View</i></a></div></td>
            </tr> 
            ';
    }
?>               
</tbody>
</table>