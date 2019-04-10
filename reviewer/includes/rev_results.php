<h2 style="background-color:#118ce6; text-align:center; color:#000000">Results to Review</h2>
     <hr style=" border: 1px solid #cbe509;" />

<?php
global $num_forms; 
$form_assigned_app_results=mysqli_query( $bd,"SELECT * FROM assigned_app_results where rev_id='$rev_id' and status = 'Not Reviewed'"); 
$num_forms = mysqli_num_rows ($form_assigned_app_results);
echo '<p>Total forms: [ <i>'. $num_forms .'</i> ]</p>';
?>

<table class="table table-striped table-bordered">
    <thead>
    <tr>
    <th style="text-align:center"> <p><strong>FORM Id</strong></p></th>
    <th style="text-align:center"> <p><strong>Date Assigned</strong></p></th> 
    <th class="td-actions"> </th>
    </tr>
    </thead>
    <tbody>
<?php

    while ($row_form_assigned_app_results=mysqli_fetch_array($form_assigned_app_results)) {    
        $form_id =$row_form_assigned_app_results['form_id'];
        $sec_id =$row_form_assigned_app_results['sec_id'];
        $status =$row_form_assigned_app_results['status'];
        $date_assigned =$row_form_assigned_app_results['date_assigned'];
                               
        echo '
         <tr>
                    <td> <p style="text-align:center"><strong> 3rdLForm#'.$form_id.'</strong></p> </td>
                    <td> <p style="text-align:center"><strong>'.$date_assigned.'</strong></p> </td>
                    <td class="td-actions"><a href="review_p1.php?result&reviewed=1&id='.$form_id.'" class="btn btn-small btn-warning"><i class="btn-icon-only icon-ok"> Review Form </i></a></td>
                  </tr>   
        ';
    }
?>

                    
         </tbody>
    </table>