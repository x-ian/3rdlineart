<?php
// Identical to one at top level include except for path here!
include ('../includes/config.php');
session_start();
?>

<?php
$dcode = $_POST['dcode'];
$bycode = $_POST['bycode'];
$facname_only = $_POST['facname_only'];
// echo "<br>$bycode";

if ($bycode != '') {
    $facilitys = mysqli_query( $bd,"SELECT dcode,name FROM facilitys WHERE facilitycode ='$bycode'"); 
    while ($row_facility = mysqli_fetch_array($facilitys)) {
        $facility_name = $row_facility['name'];
        $facility_dcode = $row_facility['dcode'];
        echo "$facility_dcode";
        // echo "<option value=\"$facility_dcode\">" . $facility_dcode . "</option>";        
    }
} else {
    echo "
<!DOCTYPE html>
<html lang=\"en\">  
  <head>
    <meta charset=\"utf-8\">
  </head>";

    if ($dcode != '0') {
        echo "<option>Select ART Clinic $dcode</option>";
        $facilitys = mysqli_query( $bd,"SELECT name,facilitycode FROM facilitys WHERE dcode = '$dcode'"); 
        while ($row_facility = mysqli_fetch_array($facilitys)) {
            $facility_name = $row_facility['name'];
            $facility_code = $row_facility['facilitycode'];
            // echo "<br>$facility_code";
            if ($facname_only)
                echo "<option value=\"$facility_name\">" . $facility_name . "</option>";
            else
                echo "<option value=\"$facility_code\">" . $facility_name . "</option>";
        }
    } else {
        echo "<option select=\"selected\">Select ART Clinic District</option>";        
        $district = mysqli_query( $bd,"SELECT distinct dcode FROM facilitys"); 
        while ($row_district = mysqli_fetch_array($district)){
            $district_name = $row_district['dcode'];
            $selected = ""; // ($pat_art_clinic == $facility_name ? 'selected="selected"' : '');
            echo "<option $selected>".$district_name.'</option>';
        }        
    }
    echo "
</html>
";
}
?>
