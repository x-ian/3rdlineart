<?php
// echo "<br> in nav_sub clinicianID is $clinicianID";
function makebuttons($btname) {
    global $clinician_query, $bd, $clinicianID;
    
    $buttons = [
        'part_1' => ['New Application<br>& Incomplete<br>Forms', 'app_incomplete_referral' ],
        'completed' => ['Completed<br>Forms<br>Status', 'app_total' ],
        'rejec' => ['Rejected<br>Forms', 'app_rejected' ], 
        'rev' => ['Referral<br>w/Decisions', 'app_refer_decisions' ],
        'rev_complete' => ['Completed<br>Referral<br>w/Decisions', 'app_refer_decisions_complete' ],
        'conso2' => ['Genotype<br>Results', 'app_genotype_res' ],
    ];
    foreach ($buttons as $name => $label_query) {
        if ($label_query[1] == '')
            continue;
        $label = $label_query[0];
        $query = $label_query[1];
        $p = $name == 'new' ? 'p' : $name;
        $forms = mysqli_query($bd, sprintf($clinician_query[$query], $clinicianID));
        $num_forms = mysqli_num_rows($forms) ? mysqli_num_rows($forms) : 0;
        // echo '<li class="'.($btname==$name?'active':'').'"><a href="app.php?'.$p.'"><i class="icon-th-list" style="height:16px; font-size: 16px;">&nbsp('.$num_forms.')</i><span style="padding: 10px; align: left;font-size: 14px;">&nbsp&nbsp'.$label.'</span></a> </li>';
        echo '<li class="'.($btname==$name?'active':'').'"><a href="app.php?'.$p.'"><i class="icon-th-list">&nbsp('.$num_forms.')</i><span style="font-size:14px;">'.$label.'</span></a> </li>';        
    }
}
?>

<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <!-- <a href="app.php?p"><img src="img/app_log.png" width="100px"><div class="mainnav2">Clinician<div></a></li> -->
        <li><a href="app.php?p"><div class="img-with-text"><img src="img/app_log.png" width="100px">Clinician</div></a></li>
        <!-- <li class=""><a href="app.php?dash"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li> -->
<?php makebuttons(''); ?>
        <li><a href="reports.php" target="_blank"><i class="icon-bar-chart"></i><span>Reports</span></a></li>
        <?php session_start();
$url = "$rooturl/reviewer/review_p1.php?p&reviewer=1";
echo ($_SESSION['reviewer'] == '1' && $role != 'Reviewer') ? ('<li><i class="icon-user" style="margin: 10px; font-size:20px"></i><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br>Reviewer</a></li>') : '';

$url = "$rooturl/check_point/cp_p1.php?p&secretary=1";
echo ($_SESSION['secretary'] == '1' && $role != 'Secretary') ? ('<li><i class="icon-user" style="margin: 10px; font-size:20px"></i><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br>Secretary</a></li>') : '';
?>
       </ul>
    </div>
  </div>
</div>
