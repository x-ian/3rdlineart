<?php

if(isset($_POST['update_treatment3'])){ 
	
    $patient_id = mysqli_real_escape_string($bd, $_GET['pat_id']);
    $tb_treat = mysqli_real_escape_string($bd, $_POST['tb_treat']);
    
    $sql_delete_treatment3 = "DELETE FROM tb_treat where pat_id = $patient_id";
    mysqli_query( $bd,$sql_delete_treatment3);
    
    $sql_delete_tb_treat_regimen1 = "DELETE FROM tb_treat_regimen1 where pat_id = $patient_id";
    mysqli_query( $bd,$sql_delete_tb_treat_regimen1);
    
    $sql_delete_tb_treat_regimen2 = "DELETE FROM tb_treat_regimen2 where pat_id = $patient_id";
    mysqli_query( $bd,$sql_delete_tb_treat_regimen2);
    
    $sql_delete_tb_treat_mdr = "DELETE FROM tb_treat_mdr where pat_id = $patient_id";
    mysqli_query( $bd,$sql_delete_tb_treat_mdr);
	
    if (mysqli_query($bd, $sql_delete_treatment3)){
    echo '<div class="alert alert-success">
               <button type="button" class="close" data-dismiss="alert">&times;</button>
               <strong>TB treatment updated</strong> 
          </div>';
    }
    
    $insert_tb_treat=" INSERT  INTO  tb_treat (tb_treatment,pat_id)
                VALUES ('$tb_treat', '$patient_id')";
                mysqli_query( $bd,$insert_tb_treat);	

    if ($tb_treat=='Yes'){        
        if(isset($_POST['regimen1_checked'])){
            for ($i=1; $i<=5; $i++) {
                if ($_POST['tbstart_date1'.$i] != '') {
                    $reg_name= mysqli_real_escape_string($bd, $_POST['reg1'.$i]);
                    $tbstart_date=mysqli_real_escape_string($bd, $_POST['tbstart_date1'.$i]); 
                    $tbstop_date=mysqli_real_escape_string($bd, $_POST['tbstop_date1'.$i]); 
                    $reason_o_changes=mysqli_real_escape_string($bd, $_POST['reason_o_changes1'.$i]);
                    // echo "'$patient_id', '$reg_name', '$tbstart_date', '$tbstop_date', '$reason_o_changes'";
                    $insert_tb_treat_regimen1=" INSERT  INTO  tb_treat_regimen1
                       (pat_id,reg_name,start_date,stop_date,reason_for_change)
                       VALUES (
                       '$patient_id', '$reg_name', '$tbstart_date', '$tbstop_date', '$reason_o_changes')";
                    mysqli_query( $bd,$insert_tb_treat_regimen1);
                }
            }
        }
        
        if (isset($_POST['regimen2_checked'])) { 
            for ($i=1; $i<=5; $i++) {
                if ($_POST['tbstart_date2'.$i] != '') {
                    $reg_name2= mysqli_real_escape_string($bd, $_POST['reg2'.$i]);
                    $tbstart_date2=mysqli_real_escape_string($bd, $_POST['tbstart_date2'.$i]); 
                    $tbstop_date2=mysqli_real_escape_string($bd, $_POST['tbstop_date2'.$i]); 
                    $reason_o_changes2=mysqli_real_escape_string($bd, $_POST['reason_o_changes2'.$i]);                  
                    $insert_tb_treat_regimen2=" INSERT INTO tb_treat_regimen2
                      (pat_id,reg_name,start_date,stop_date,reason_for_change)
                      VALUES (
                      '$patient_id', '$reg_name2', '$tbstart_date2', '$tbstop_date2', '$reason_o_changes2')";
                    mysqli_query( $bd,$insert_tb_treat_regimen2);
                }
            }
        }
    
        if (isset($_POST['mdr_checked'])) { 
            for($i=1; $i<=5; $i++) {
                if ($_POST['tbstart_date_mdr'.$i] != '') {
                    $mdr= mysqli_real_escape_string($bd, $_POST['mdr'.$i]);
                    $tbstart_date_mdr=mysqli_real_escape_string($bd, $_POST['tbstart_date_mdr'.$i]); 
                    $tbstop_date_mdr=mysqli_real_escape_string($bd, $_POST['tbstop_date_mdr'.$i]); 
                    $reason_o_changes_mdr=mysqli_real_escape_string($bd, $_POST['reason_o_changes_mdr'.$i]);
                    $insert_tb_treat_mdr="INSERT INTO tb_treat_mdr
                          (pat_id,reg_name,start_date,stop_date,reason_for_change)
                          VALUES (
                          '$patient_id', '$mdr', '$tbstart_date_mdr', '$tbstop_date_mdr', '$reason_o_changes_mdr')";

                    mysqli_query( $bd,$insert_tb_treat_mdr);
                }
            }
        }       
    }
    
    //  mysqli_commit($db);
}

?>