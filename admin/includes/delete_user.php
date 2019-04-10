<?php

if(isset($_GET['del_user'])) { 
	$user_id = $_GET['id'];
	$reload = $_GET['page'];
	
	$sql_user = "DELETE FROM users WHERE id =$user_id";
	if (mysqli_query($bd, $sql_user)){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00">You have <strong> deleted </strong> a User. </p>	   
	</div>
	';
    }
echo "<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?p\">"; 
}

?>