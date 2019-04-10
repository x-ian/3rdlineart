<?php
if(isset($_GET['remove_x'])){ 
    $id =$_GET['id'];
    $reload =$_GET['page'];
    
    if ($reload =='man_drugs'){
            $sql_drugs = "DELETE FROM drugs WHERE id =$id";

            if (mysqli_query($bd, $sql_drugs)){
            echo '  <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p style="color:#f00">You have <strong> deleted </strong> a drug. </p>
                    </div>
           ';    }
    }
    if ($reload =='man_facility'){
            $sql_facility = "DELETE FROM facility WHERE id =$id";

            if (mysqli_query($bd, $sql_facility)){
            echo '  <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p style="color:#f00">You have <strong> deleted </strong> a facility. </p>
                    </div>
           ';      }
    }
    if ($reload =='man_affliates'){
            $sql_partner_org = "DELETE FROM partner_org WHERE id =$id";

            if (mysqli_query($bd, $sql_partner_org)){
            echo '  <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p style="color:#f00">You have <strong> deleted </strong> an Organization. </p>
                    </div>
           ';     }
    }
    echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?".$reload."\">"; 
}
?>