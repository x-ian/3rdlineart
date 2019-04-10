<script type="text/javascript" >
function changeClass(id)
{
    // alert(id);
    document.getElementById(id).classList.toggle('active');        
}

</script>
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
          <li><a href="dash.php?p"><img src="../img/app_log.png" width="100px"></a></li> 
<?php
 function makebuttons($btname) {
    global $admin_query, $bd;
    
    $buttons = [
        'man_facility' => ['Facilities', 'select_facilitys' ],
        'man_drugs' => ['Drugs', 'select_drugs' ], 
        'man_affliates' => ['Affiliates', 'select_affiliates' ],
        'man_rev' => ['Reviewers', 'select_rev' ],
        'man_clin' => ['Clinicians', 'select_clinician' ],
        'man_lab' => ['Lab Staff', 'select_labs' ],
        'man_sec' => ['Secretaries', 'select_sec' ],
        'man_admin' => ['Admins', 'select_admin' ],
        'man_apps' => ['Patient<br>Apps', 'select_apps' ],
//        'man_supp' => ['Supply<br>Chains', 'select_supp' ],
    ];
    foreach ($buttons as $name => $label_query) {
        if ($label_query[1] == '')
            continue;
        $label = $label_query[0];
        $query = $label_query[1];
        $p = $name == 'new' ? 'p' : $name;
        $forms = mysqli_query($bd, $admin_query[$query]);
        $num_forms = mysqli_num_rows($forms) ?  mysqli_num_rows($forms) : 0;
        // $num_forms = '?';
        // echo '<li class="'.($btname==$name?'active':'').'"><a href="dash.php?'.$p.'"><i class="icon-th-list" style="height:10px; font-size: 16px;"></i><span style="offset:-10px; padding: 10px; align: left;font-size: 14px;">('.$num_forms.')<br>&nbsp'.$label.'</span></a> </li>';
        echo '<li class="'.($btname==$name?'active':'').'"><a href="dash.php?'.$p.'"><i class="icon-th-list">&nbsp('.$num_forms.')</i><span style="font-size: 14px;">'.$label.'</span> </a> </li>';        
    }
}

if(isset($_GET['man_facility'])) { 
    makebuttons('man_facility');
}

else if(isset($_GET['man_drugs'])) { 
    makebuttons('man_drugs');
}
          
else if(isset($_GET['man_affliates'])) { 
    makebuttons('man_affliates');
}

else if(isset($_GET['man_rev'])) { 
    makebuttons('man_rev');
}

else if(isset($_GET['man_clin'])) { 
    makebuttons('man_clin');
}

else if(isset($_GET['man_lab'])) { 
    makebuttons('man_lab');
}

else if(isset($_GET['man_sec'])) { 
    makebuttons('man_sec');
}

else if(isset($_GET['man_supp'])) {
    makebuttons('man_supp');
}    

else if(isset($_GET['man_reports'])) {
    makebuttons('man_reports');
}

else if(isset($_GET['man_apps'])) {
    makebuttons('man_apps');
}

else
    makebuttons('');



     ?>
<!--
    <li><a href="dash.php?p"><img src="../img/app_log.png" width="100px"></a></li> 
     <li id="Facility_menubtn" onclick=changeClass(id)><a href="dash.php?man_facility" class="button btn btn-invert btn-large" style="margin:5px">Facility</a></li> 
     <li id="Drugs_menubtn" onclick=changeClass(id)><a href="dash.php?man_drugs" class="button btn btn-invert btn-large" style="margin:5px">Drugs</a></li>
     <li id="Affiliates_menubtn" onclick=changeClass(id)><a href="dash.php?man_affliates" class="button btn btn-invert btn-large" style="margin:5px">Affiliates</a></li>
     <li id="Reviewers_menubtn" onclick=changeClass(id)><a href="dash.php?man_rev" class="button btn btn-invert btn-large" style="margin:5px">Reviewers</a></li>
     <li id="Clinicians_menubtn" onclick=changeClass(id)><a href="dash.php?man_clin" class="button btn btn-invert btn-large" style="margin:5px">Clinicians</a></li>           
     <li id="Labuser_menubtn" onclick=changeClass(id)><a href="dash.php?man_lab" class="button btn btn-invert btn-large" style="margin:5px">Lab user</a></li>
     <li id="Secretary_menubtn" onclick=changeClass(id)><a href="dash.php?man_sec" class="button btn btn-invert btn-large" style="margin:5px">Secretary</a></li>
     <li id="Supplychain_menubtn" onclick=changeClass(id)><a href="dash.php?man_supp" class="button btn btn-invert btn-large" style="margin:5px">Supply Chain</a></li>
     <li id="Reports_menubtn" onclick=changeClass(id)><a href="../reports.php" target="_blank" class="button btn btn-invert btn-large" style="margin:5px">Reports</a> </li>
-->  
      </ul>
    </div>
  </div>
</div>
