<style>
.img-with-text {
    text-align: justify;
    width: 100px;
    font-size: 16px;
    font-weight: bold;
}

.img-with-text img {
    display: block;
    margin: 0 auto;
}

.mainnav2 {
   background: transparent;
   font-size: 16px;
   font-weight: bold;
}
</style>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><a class="brand" href="#">3rd Line ART Expert Committee Malawi </a>
     <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                  class="icon-user"></i> <?php echo $loginfullname ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">         
              <li><a href="javascript:;">Profile</a></li>
    
<?php session_start();
// echo "<br>reviewer=".$_SESSION['reviewer'];     
// echo "<br>role is '$role'".", isClinician: ".$_SESSION['clinician'];
$url = "$rooturl/reviewer/review_p1.php?p";
echo ($_SESSION['reviewer'] == '1' && $role != 'Reviewer') ? ('<li><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br>Reviewer</a></li>') : '';
$url = "$rooturl/check_point/cp_p1.php?p";
echo ($_SESSION['secretary'] == '1' && $role != 'Secretary') ? ('<li><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br> Secretary</a></li>') : '';
$url = "$rooturl/app.php?p";
echo ($_SESSION['clinician'] == '1' && $role != 'Clinician') ? ('<li><a type="submit" style="padding:10px;font-size:16px; font-style:bold;" href="'.$url.'">Switch to<br>Clinician</a></li>') : '';
?>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
</div>
</div>
