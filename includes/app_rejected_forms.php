
<h2 style="background-color:#fd1f0d; text-align:center; color:#000000">Rejected-Incomplete Forms</h2>
                        <hr style=" border: 1px solid #cbe509;" />
                    
     <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th> 3rdlineForm# </th>
                    <th> Patient Name </th>
                    <th> ART_Number</th>
                    <th> Gender</th>
                    <th> Date Created</th>
                    <th> View Comment</th>
                  </tr>
                </thead>
                <tbody>
<?php
     global $num_newforms, $clinicianID;
// echo "<br>in app_rejected_forms clinicianID is $clinicianID";
$query_rejected = sprintf($clinician_query['app_rejected'], $clinicianID);
// echo "<br>$query_rejected";
$form_creation = mysqli_query( $bd, $query_rejected);
$num_newforms = mysqli_num_rows ($form_creation);

// echo '<p>Total forms: [ <i>'. $num_newforms .'</i> ]</p>';
    while ($row_form_creation = mysqli_fetch_array($form_creation)){
        
        $form_id = $row_form_creation['form_id'];
        $clinician_id = $row_form_creation['clinician_id'];
        $patient_id = $row_form_creation['patient_id'];
        $status = $row_form_creation['status'];
        $form_complete = $row_form_creation['complete'];
        $date_created = $row_form_creation['date_created'];
        $comment = $row_form_creation['comment'];

        $patient = new Patient($patient_id);
        echo '<tr>
                    <td> <p style="text-align:left"><strong> 3rdLForm'.$form_id.'</strong></p></td>
                    <td><p style="text-align:left"><strong>'.$patient->fullname.'</strong></p></td>
                    <td><p style="text-align:left"><strong>'.$patient->art_id_num.'</strong></p></td>
                    <td><p style="text-align:left"><strong>'.$patient->gender.'</strong></p></td>
                    <td><p style="text-align:left"><strong>'.$patient->date_created.'</strong></p></td>
                    <td>
    <form id="search_art" action="app.php" method="post">
    <input type="hidden" name="form_id" value="'.$form_id.'" />
    <input type="hidden" name="id" value="'.$patient_id.'" />
    <input type="hidden" name="comment" value="'.comment.'" />
                                                    
<button type="submit" name="search" class="btn btn-success" style="width:90%;" >Edit form</button>
 </form>                                                      
                      
                                            
                    </td>
                  </tr> 
                  
                  ';
    }

?>
                 
         </tbody>
    </table>