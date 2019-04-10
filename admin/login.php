<?PHP
session_start();
// include("../includes/config.php");
include ('../includes/head.php');
global $fullname, $username, $role, $enckey, $salt;

$username = "";
$pword = "";
$errorMessage = "";

//==========================================
//	ESCAPE DANGEROUS SQL CHARACTERS
//==========================================
function quote_smart($value, $handle) {

	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}

	if (!is_numeric($value)) {
		$value = "'" . mysqli_real_escape_string($handle, $value) . "'";       
	}
	return $value;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST['username'];
	$pword = $_POST['password'];

	// $use=$username;
	// $username = htmlspecialchars($username);
	//  $pword = htmlspecialchars($pword);

	// $username = quote_smart($username, $bd);
	// $pword = quote_smart($pword, $bd);
    $pword = mysqli_real_escape_string($bd, $pword);
    $username = mysqli_real_escape_string($bd, $username);
        
    $pword = hasword ($pword, $salt);
    $username = encrypt ($username, $enckey);
  
	$SQL = "SELECT * FROM users WHERE username='$username' AND password='$pword'";
	$result = mysqli_query($bd,$SQL);
	$num_rows = mysqli_num_rows($result);
    
	if($num_rows != 0){
		$SQL_user = "SELECT * FROM users WHERE username='$username'";                
		$user = mysqli_query($bd,$SQL_user);
		while($row_user = mysqli_fetch_array($user)) {
			$role = $row_user['role'];
			$user_id = $row_user['id'];
			// echo("role is ".$role);
            $role = decrypt($role, $enckey);
			// echo("<br>role is ".$role);            
            // exit();
			$_SESSION['login'] = 'true';
			$_SESSION['username'] = $row_user['username'];
            $_SESSION['identification'] = $row_user['id'];
            $_SESSION['start'] = time(); // taking now logged in time
            $_SESSION['expire'] = $_SESSION['start'] + (60 * 60) ;
            //header ("Location:".$pageLocation);
            
            if ($role=='Admin'){
                $SQL_admin = "SELECT * FROM admin WHERE user_id = $user_id";
                $admin = mysqli_query($bd, $SQL_admin);
                $row_admin = mysqli_fetch_array($admin);
                $_SESSION['id'] = $row_admin['id'];
                $_SESSION['fname'] = $row_admin['fname'];
                $_SESSION['lname'] = $row_admin['lname'];
                echo"<meta http-equiv=\"Refresh\" content=\"0; url=dash.php?p\">";    
            }
            else {
                $error="fail" ;
                echo"<meta http-equiv=\"Refresh\" content=\"0; url=index.php?error=$error&sub=login\">";
            }
        }
    }

    
    // if ($num_rows == 0)
    else {
        	$error="fail" ;
        	echo"<meta http-equiv=\"Refresh\" content=\"0; url=index.php?error=$error&sub=login\">";
        }


    }






    ?>
