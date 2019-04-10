<?php

if(isset($_POST['submit_treatment3'])) { 
	
	$patient_id = mysqli_real_escape_string($bd, $_GET['pat_id']);
	$tb_treat = mysqli_real_escape_string($bd, $_POST['tb_treat']);

	$insert_tb_treat = "INSERT INTO tb_treat (tb_treatment,pat_id)
	VALUES ('$tb_treat', '$patient_id')";
	mysqli_query($bd, $insert_tb_treat);	

	if ($tb_treat=='Yes') {

		if(isset($_POST['regimen1_checked'])) { 
			$arr = array(1, 12, 13, 14, 15);
			foreach ($arr as $i) {
				$reg_name= mysqli_real_escape_string($bd, $_POST['reg'.$i]);
				$tbstart_date=mysqli_real_escape_string($bd, $_POST['tbstart_date'.$i]); 
				$tbstop_date=mysqli_real_escape_string($bd, $_POST['tbstop_date'.$i]); 
				$reason_o_changes=mysqli_real_escape_string($bd, $_POST['reason_o_changes'.$i]);

				$insert_tb_treat_regimen1 = "INSERT INTO tb_treat_regimen1
				(pat_id,reg_name,start_date,stop_date,reason_for_change)
				VALUES ('$patient_id', '$reg_name', '$tbstart_date', '$tbstop_date', '$reason_o_changes')";

				mysqli_query($bd, $insert_tb_treat_regimen1);
			}
		}

		if(isset($_POST['regimen2_checked'])) { 
			$arr = array(2, 22, 23, 24, 25);
			foreach ($arr as $i) {          
				$reg_name = mysqli_real_escape_string($bd, $_POST['reg'.$i]);
				$tbstart_date = mysqli_real_escape_string($bd, $_POST['tbstart_date'.$i]); 
				$tbstop_date = mysqli_real_escape_string($bd, $_POST['tbstop_date'.$i]); 
				$reason_o_changes = mysqli_real_escape_string($bd, $_POST['reason_o_changes'.$i]);

				if ($reg_name != '' and $tbstart_date != '' and $tbstop_date != '') {

					$insert_tb_treat_regimen2 = "INSERT INTO tb_treat_regimen2
					(pat_id,reg_name,start_date,stop_date,reason_for_change)
					VALUES ('$patient_id', '$reg_name', '$tbstart_date', '$tbstop_date', '$reason_o_changes')";
					mysqli_query( $bd, $insert_tb_treat_regimen2);
				}
			}
		}

		if(isset($_POST['mdr_checked'])){ 
			for ($i=1; $i<=5; $i++) {
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

?>