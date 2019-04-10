<form id="edit-profile" class="form-horizontal" action="#" method="post">
<h2 style="background-color:#e5e5e5; text-align:center; color:#000000">Application with Decision</h2>
     <hr style=" border: 1px solid #cbe509;" />
     
     <table class="table table-bordered">
     <thead>
     <tr>
     <th style="text-align:center"> <p><strong>FORM Id</strong></p></th> 
     <th class="td-actions" style="text-align:center"><p><strong>Review</strong></p> </th>
     
     
     </tr>
     </thead>
     <tbody>
<?php
     $rev_complete = isset($_GET['rev_complete']) ? '&sample_already_requested' : '';
     while ($row_form_creation = mysqli_fetch_array($form_creation)){
         $_3rdlineart_form_id = $row_form_creation['3rdlineart_form_id'];
         $genotyping = $row_form_creation['genotyping'];
         $comment_to_clinician = $row_form_creation['comment_to_clinician'];
         $status = $row_form_creation['status'];
         $date_reviewed = $row_form_creation['date_reviewed'];             
        
        echo '
        <tr>
          <td> <p style="text-align:center"><strong><a href="#"> 3rdLForm#'.$_3rdlineart_form_id.'</a></strong></p> </td>
          <td> 
               <p style="text-align:center"><strong>'.$date_reviewed.'</strong></p>
          </td>
          <td class="td-actions"><a href="app.php?view'.$rev_complete.'&formid='. $_3rdlineart_form_id.'" style="float:right" class="btn btn-large btn-invert"><i class="btn-icon-only icon-ok">View Review</i></a></td>
        </tr>
        ';
       /*<td class="td-actions"><a href="app.php?p&sendsample&formid='. $_3rdlineart_form_id.'" class="btn btn-large btn-invert"><i class="btn-icon-only icon-ok"> View Review </i></a></td>*/
    }

?>
     </tbody>
</table>
</form>

