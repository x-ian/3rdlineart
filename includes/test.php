<?php

$colors = ["red", "green", "blue"];
/*
for($regimen=1; $regimen<=3; $regimen++) {
    $regnamecl = $regimen<3 ? "r$regimen" : 'mdr_';
    $regname = $regimen<3 ? "$regimen" : 'mdr_';
    $regrow = 0;

    for ($col=1; $col<=5; $col++) {
        $color = $colors[$regimen-1];

        $regrowm1 = $regrow - 1;
        $regrowp1 = $regrow + 1;
        $regrowm2 = $regrowp1 - 1;
        
        $regrow1 = $regnamecl.'+row'.($regrow+1);
        $regrow2 = $regnamecl.'-row'.($regrow); // was $regname-1
        if ($regrow < 4) {
            echo "\nif($(this).attr(\"name\")==\"$regnamecl+row$regrowp1\"){
                $(\".sec$regrowp1\").not(\".row$regrowp1\").hide();
                $(\".$regnamecl"."row$regrowp1\").show();".
                ($regrow > 0 ? "
                $(\".$regnamecl"."sec$regrowm2\").hide();
                $(\".$regnamecl"."sec$regrowp1\").show();":"").
            "\n}";
        }
        if ($regrow > 0) {
            $reshow = ($regrowm1 == 0) ? "sec1" : $regnamecl."sec$regrowm1";
            echo "\nif($(this).attr(\"name\")==\"$regnamecl-row$regrow\"){
                $(\".$regnamecl"."row$regrow\").hide();
                $(\".$reshow\").show();
            }";
        }
        $regrow++;
    }
}
*/
for($regimen=1; $regimen<=3; $regimen++) {
    $regnamecl = $regimen<3 ? "r$regimen" : 'mdr_';
    $regname = $regimen<3 ? "$regimen" : 'mdr_';
    $regrow = 0;

    for ($col=0; $col<5; $col++) {
        $cols = $col ? $col : '';
        // $datepicker_2 = $datepicker + 1;
        $color = $colors[$regimen-1];

        $regrowp1 = $regrow+1;
        $regrowp2 = $regrowp1+1;

        $regrow1 = $regnamecl.'+row'.($regrowp1);
        $regrow2 = $regnamecl.'-row'.($regrow); // was $regname-1
        if ($regrow < 5) {
            echo "if($(this).attr(\"name\")==\"$regnamecl+row$regrow\"){
                 $(\".$regnamecl"."row$regrowp1\").show();
                 $(\".$regnamecl"."butts$col\").hide();
                 $(\".$regnamecl"."butts$regrow\").show();
            }";
        }
        if ($regrow > 0) {
            echo "if($(this).attr(\"name\")==\"$regnamecl-row$regrow\"){
                $(\".$regnamecl$regrow\").hide();
                $(\".$regnamecl"."butts$cols\").show();
                $(\".$regnamecl"."butts$regrowp2\").hide();
            }";
        }
        $regrow++;
    }
}

exit();

/* test data
$PeripheralNeuropathy='Yes';
$Jaundice='No';
$Lipodystrophy='No';
*/

$condition = [
"PeripheralNeuropathy"=>'Perpheral Neuropathy',
"Jaundice"=>'Jaundice',
"Lipodystrophy"=>'Lipodystrophy',
"KidneyFailure"=>'Kidney Failure',
"Psychosis"=>'Psychosis',
"Gynecomastia"=>'Gynecomastia',
"Anemia"=>'Anemia'];

foreach ($condition as $key => $value) {
	eval("\$yeschecked = (\$$key=='Yes')?'checked=\"checked\"':'';");
	$nochecked = ($yeschecked == '')?'checked="checked"':'';
	echo "<tr>        

	<td></td>
	<td> 
		<label class=\"control-label\">$value</label>
		<div style=\"width:110px; float:left\" class=\"radio_sty\">                                          
			<input type=\"radio\" id=\"$key-yes\" name=\"$key\" value=\"Yes\" $yeschecked>
			<label for=\"$key-yes\">Yes</label>    
			<div class=\"check\"></div>
		</div>
		<div style=\"width:100px; float:left\" class=\"radio_sty\">
			<input type=\"radio\" id=\"$key-no\" name=\"$key\" value=\"No\" $nochecked>
			<label for=\"$key-no\">No</label>
			<div class=\"check\"></div>
		</td>
	</tr>";
}

/* test data
$sig_diarrhea_vom='Yes';
$sig_diarrhea_vom_details='Something';
$alco_drug_consump='No';
$alco_drug_consump_details='';
$trad_med='Yes';
$trad_med_details='Something else';
$co_medi='No';
$co_medi_details='';
$other_curr_problem='No';
$other_curr_problem_details='';
*/

$condition = [
"sig_diarrhea_vom"=>"Significant diarrhea or vomiting?",
"alco_drug_consump"=>"Alcohol or drug consumption?",
"trad_med"=>"Traditional medicine?",
"co_medi"=>"Current co-medications (Antiepileptic, Steroids, Warfarin, Statins)?",
"other_curr_problem"=>"Other current clinical problems?"
];

foreach ($condition as $key => $value) {
	eval("\$yeschecked = (\$$key=='Yes')?'checked=\"checked\"':'';");
	$nochecked = ($yeschecked == '')?'checked="checked"':'';
          // echo "\$details = (\$$key=='Yes')?'value=\"\$$key"."_details\"':''";
	eval("\$detailval = \$$key"."_details;");
	eval("\$details = (\$$key=='Yes')?'value=\"$detailval\"':'';");
          // echo "$details";
	
	echo "
	<tr>
		<td> 
			<label class=\"control-label\">$value</label>  
			<div style=\"width:110px; float:left\" class=\"radio_sty\">
				<input type=\"radio\" id=\"$key-yes\" name=\"$key\" value=\"Yes\" $yeschecked >
				<label for=\"$key-yes\">Yes</label>
				<div class=\"check\"></div>
			</div>
			<div style=\"width:100px; float:left\" class=\"radio_sty\">
				<input type=\"radio\" id=\"$key-no\" name=\"$key\" value=\"No\" $nochecked >
				<label for=\"$key-no\">No</label>
				<div class=\"check\"></div>
			</div> 
		</td>
		<td>
			Details
		</td>
		<td>
			<input type=\"text\" class=\"span4\" id=\"$key"."_details\" name=\"$key"."_details\" $details>
		</td> 
	</tr>
	";
	
}
?>