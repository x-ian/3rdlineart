<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
     <!-- <li><a href="cp_p1.php?p"><img src="../img/app_log.png" width="100px"></a></li> -->
     <li><a href="cp_p1.php?p"><div class="img-with-text"><img src="../img/app_log.png" width="100px">Secretary</div></a></li>     
<?php
//     global $num_newforms; 

$which = '';

function makebuttons($btname) {
    global $cp_query, $bd;
    
    $buttons = [
        'new' => ['New App', 'select_new_forms'],
        'rev' => ['Apps<br>Under Rev', 'select_assigned_forms'], 
        'reviewed_app' => ['Reviewed<br>Apps', 'select_expert_review_consolidate1'],
        'pending_sample' => ['Pending<br>Samples<br>Awaiting Retest', 'select_sec_pending_sample'],
        'pending_result' =>['Pending<br>Results', 'select_sec_pending_results'],
        'pending' => ['Results Under<br>Review', 'select_sec_results_under_review'],
        'reviewed_result' => ['Reviewed<br>Results', 'select_sec_reviewed_results'],
//        'reminder' => ['6 Months<br>Reminder', ''],
    ];
    foreach ($buttons as $name => $label_query) {
        if ($label_query[1] == '')
            continue;
        $label = $label_query[0];
        $query = $label_query[1];
        $p = $name == 'new' ? 'p' : $name;
        $forms = mysqli_query($bd, $cp_query[$query]);
        $num_forms = mysqli_num_rows($forms) ?  mysqli_num_rows($forms) : 0;
        // echo '<li class="'.($btname==$name?'active':'').'"><a href="app.php?'.$p.'"><i class="icon-th-list" style="height:16px; font-size: 16px;">&nbsp('.$num_forms.')</i><span style="padding:10px; align:left;font-size: 14px;">&nbsp&nbsp'.$label.'</span></a> </li>';
        
        echo '<li class="'.($btname==$name?'active':'').'"><a href="cp_p1.php?'.$p.'"><i class="icon-th-list">&nbsp('.$num_forms.')</i><span style="font-size: 14px;">'.$label.'</span> </a> </li>';
    }
    
    echo '        
         <li class="'.($btname=='reminder'?'active':'').'"><a href="cp_p1.php?reminder"><i class="icon-th-list"></i><span>6 Months<br>Reminder</span> </a> </li>    
        ';
}

if(isset($_GET['p'])){ 
    makebuttons('new');
}

else if(isset($_GET['rev'])){ 
    makebuttons('rev');
}
          
else if(isset($_GET['reviewed_app'])){ 
    makebuttons('reviewed_app');
}

else if(isset($_GET['pending_sample'])){ 
    makebuttons('pending_sample');
}

else if(isset($_GET['pending_result'])){ 
    makebuttons('pending_result');
}

else if(isset($_GET['pending'])){ 
    makebuttons('pending');
}

else if(isset($_GET['reviewed_result'])){ 
    makebuttons('reviewed_result');
}

else if(isset($_GET['reminder'])){
    makebuttons('reminder');
}

else makebuttons('');
         
?>
  <li class=""><a href="../reports.php" target="_blank"><i class="icon-bar-chart"></i><span>Reports</span> </a> </li>

<?php session_start();
// echo "role '$role'".", Clin: ".$_SESSION['clinician'].", Rev: ".$_SESSION['reviewer'];
$url = "$rooturl/reviewer/review_p1.php?p";
echo ($_SESSION['reviewer'] == '1' && $role != 'Reviewer') ? ('<li><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br>Reviewer</a></li>') : '';

$url = "$rooturl/check_point/cp_p1.php?p";
echo ($_SESSION['secretary'] == '1' && $role != 'Secretary') ? ('<li><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br> Secretary</a></li>') : '';

$url = "$rooturl/app.php?p";
echo ($_SESSION['clinician'] == '1' && $role != 'Clinician') ? ('<li><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br>Clinician</a></li>') : '';
?>
    </ul>
    </div>
  </div>
</div>
