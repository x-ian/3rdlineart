<?php

$patient_table=mysqli_query( $bd,"SELECT id FROM  patient where id='$pat_id' ");    
$if_exist_patient_table = mysqli_num_rows ($patient_table);
if ($if_exist_patient_table !='0') {
    echo '<a href="app.php?back&part_1&pat_id='.$pat_id.'" class="btn" style="padding:10px; font-size:180%, margin:5px 0"> << Back to Start</a>';
} 

?>