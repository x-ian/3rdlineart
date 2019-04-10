<?php
// echo '<br>loading queries...';

if (file_exists('config.php')) {
    include_once('config.php');    
    include_once('crypt_function.php');
} else {
    include_once('includes/config.php');
    include_once('crypt_function.php');
}

//calculating age of patient 
function getAge($dobf) { 
    $dob = explode("/", $dobf);
    $curMonth = date("m");
    $curDay = date("j");
    $curYear = date("Y");
    // echo "curYear: $curYear";
    $age = $curYear - $dob[2]; 
    if($curMonth<$dob[1] || ($curMonth==$dob[1] && $curDay<$dob[0])) 
         $age--;
    // echo "$dob[2], $curYear, $age";
    return $age; 
}

class User {
    public $id;
    public $username;
    public $fullname;
    public $firstname;
    public $lastname;
	public $email;
	public $phone;
	public $password;
	public $role; // now means "primary" role

    public $title;
    
    public $clinician = 0;
    public $reviewer = 0;
    public $secretary = 0;
    
    public $reviewerID;
    public $clinicianID;
    public $secretaryID;

    // role specific fields...
    public $art_clinic;
    public $affiliate_institution;
    public $snapshot;
    
    public function __construct() {
        // allocate your stuff
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();

        if (method_exists($this, $method_name = '__construct'.($number_of_arguments>=7 ? '7' : $number_of_arguments))) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
    }

    public function __construct2($id, $role) {
        // echo 'constructor with 2 parameter ' . $id . ' ' . $role . "\n";
        $bd = $GLOBALS['bd'];
        $enckey = $GLOBALS['enckey'];

        $this->id = $id;
        
        if ($role == 'Clinican') {
            $SQL = "SELECT * FROM clinician WHERE id='$id'";
            $clinician_result = mysqli_query($bd, $SQL);
            if (mysqli_num_rows($clinician_result)) {
                $row_result = mysqli_fetch_assoc($clinician_result);
                $this->clinicianID = $row_result ['id'];            
                $this->phone = $row_result ['phone'];
                $this->email = $row_result ['email'];
                $enc = 0;
                $this->firstname = $enc ? decrypt($row_result ['fname'], $enckey) : $row_result ['fname'];
                $this->lastname = $enc ? decrypt($row_result ['lname'], $enckey) : $row_result ['lname'];
                $this->fullname = $this->firstname.' '.$this->lastname;
                
                // particular fields
                $this->art_clinic = $row_result ['art_clinic'];
                $this->clinician = 1;
            }
        }

        if ($role == 'Reviewer') {
            $SQL = "SELECT * FROM reviewer WHERE id='$id'";
            $reviewer_result = mysqli_query($bd, $SQL);
            if (mysqli_num_rows($reviewer_result)) {
                $row_result = mysqli_fetch_assoc($reviewer_result);
                $this->reviewerID = $row_result ['id'];            
                $this->title = $row_result ['title'];
                $this->phone = $row_result ['phone'];
                $this->email = $row_result ['email'];
                $enc = 0;
                $this->firstname = $enc ? decrypt($row_result ['fname'], $enckey) : $row_result ['fname'];
                $this->lastname = $enc ? decrypt($row_result ['lname'], $enckey) : $row_result ['lname'];
                if ($this->title)
                    $this->fullname = $this->title.'. '.$this->firstname.' '.$this->lastname;
                else
                    $this->fullname = $this->firstname.' '.$this->lastname;
                $this->affiliate_institution = $row_result ['affiliate_institution'];
                $this->reviewer = 1;
            }
        }

        if ($role == 'Secretary') {
            $SQL = "SELECT * FROM secretary WHERE id='$id'";
            $secretary_result = mysqli_query($bd, $SQL);

            if (mysqli_num_rows($secretary_result)) {
                // echo "<br>is a secretary!";
                $row_result = mysqli_fetch_assoc($secretary_result);
                $this->secretaryID = $row_result ['id'];
                // $this->title = $row_result ['title'];
                $this->phone = $row_result ['phone'];
                $this->email = $row_result ['email'];
                $enc = 0;
                $this->firstname = $enc ? decrypt($row_result ['fname'], $enckey) : $row_result ['fname'];
                $this->lastname = $enc ? decrypt($row_result ['lname'], $enckey) : $row_result ['lname'];
                $this->fullname = $this->firstname.' '.$this->lastname;            
                $this->secretary = 1;
            }
        }
    }

    public function __construct3($argument1, $argument2, $argument3) {
        echo 'constructor with 3 parameter ' . $argument1 . ' ' . $argument2 . ' ' . $argument3 . "\n";
    }

    public function __construct1($id) {
        $bd = $GLOBALS['bd'];
        $enckey = $GLOBALS['enckey'];        
        $enc = true;

        $query = "SELECT * FROM users WHERE id = '$id'";
        $user_result = mysqli_query($bd, $query);
        $row_user = mysqli_fetch_assoc($user_result);

        $user_id = $row_user['id'];
        $this->role = $enc ? decrypt($row_user['role'], $enckey) : $row_user['role'];
        $this->username =  $enc ? decrypt($row_user['username'], $enckey) : $row_user['username'];

        $SQL = "SELECT * FROM clinician WHERE user_id='$user_id'";
        $clinician_result = mysqli_query($bd, $SQL);
        if (mysqli_num_rows($clinician_result)) {
            $row_result = mysqli_fetch_assoc($clinician_result);            
            $this->clinicianID = $row_result ['id'];            
            $this->phone = $row_result ['phone'];
            $this->email = $row_result ['email'];
            $enc = 0;
            $this->firstname = $enc ? decrypt($row_result ['fname'], $enckey) : $row_result ['fname'];
            $this->lastname = $enc ? decrypt($row_result ['lname'], $enckey) : $row_result ['lname'];
            $this->fullname = $this->firstname.' '.$this->lastname;

            // particular fields
            $this->art_clinic = $row_result ['art_clinic'];
            $this->clinician = 1;
        }
        
        $SQL = "SELECT * FROM reviewer WHERE user_id='$user_id'";
        $reviewer_result = mysqli_query($bd, $SQL);
        if (mysqli_num_rows($reviewer_result)) {
            $row_result = mysqli_fetch_assoc($reviewer_result);
            $this->reviewerID = $row_result ['id'];            
            $this->title = $row_result ['title'];
            $this->phone = $row_result ['phone'];
            $this->email = $row_result ['email'];
            $enc = 0;
            $this->firstname = $enc ? decrypt($row_result ['fname'], $enckey) : $row_result ['fname'];
            $this->lastname = $enc ? decrypt($row_result ['lname'], $enckey) : $row_result ['lname'];
            if ($this->title)
                $this->fullname = $this->title.'. '.$this->firstname.' '.$this->lastname;
            else
                $this->fullname = $this->firstname.' '.$this->lastname;
            $this->affiliate_institution = $row_result ['affiliate_institution'];
            $this->reviewer = 1;
        }
        
        $SQL = "SELECT * FROM secretary WHERE user_id='$user_id'";
        $secretary_result = mysqli_query($bd, $SQL);

        if (mysqli_num_rows($secretary_result)) {
            // echo "<br>is a secretary!";
            $row_result = mysqli_fetch_assoc($secretary_result);
            $this->secretaryID = $row_result ['id'];
            // $this->title = $row_result ['title'];
            $this->phone = $row_result ['phone'];
            $this->email = $row_result ['email'];
            $enc = 0;
            $this->firstname = $enc ? decrypt($row_result ['fname'], $enckey) : $row_result ['fname'];
            $this->lastname = $enc ? decrypt($row_result ['lname'], $enckey) : $row_result ['lname'];
            $this->fullname = $this->firstname.' '.$this->lastname;            
            $this->secretary = 1;
        }
        $this->id = $id;
    }

    public function __construct7($username, $password, $fname, $lname, $role, $email, $phone, $isClinician=0, $isReviewer=0, $isSecretary=0, $title='', $clin_art_clinic='', $affiliate_institution='', $snapshot='') {
        $bd = $GLOBALS['bd'];
        $enckey = $GLOBALS['enckey'];
        $salt = $GLOBALS['salt'];
        $date_created = date('d/m/Y');
        $epassword = hasword ($password, $salt);
        
        $insert_users=" INSERT  INTO users
	(username,password,role,date_created)
	VALUES (
	'".encrypt ($username, $enckey)."', '$epassword', '".encrypt ($role, $enckey)."', '$date_created')";                
        mysqli_query($bd, $insert_users);
        $user_id = mysqli_insert_id($bd);
            
        if ($role == 'Clinician') {
            $insert_clinician = " INSERT INTO clinician
	(user_id,art_clinic,name,firstname,lastname,email,phone,isReviewer)
	VALUES (
	'$user_id', '$clin_art_clinic', '$this->fullname', '$fname', '$lname', '$email', '$phone', '$isReviewer')";
            try {
                mysqli_query($bd, $insert_clinician);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->errorMessage() . "\n";
                exit();
            }
            if ($isReviewer) { // clinician can also be a reviewer
                $insert_reviewer = " INSERT INTO reviewer
	(user_id,title,fname,lname,email,phone,affiliate_institution,snapshot,isClinician,isSecretary)
	VALUES (
	'$user_id', '$title', '$fname', '$lname', '$email', '$phone', '$affiliate_institution','$snapshot', '$isClinician', '$isSecretary')";
                try {
                    mysqli_query($bd, $insert_reviewer);
                } catch (Exception $e) {
                    echo 'Caught exception: '. $e->errorMessage() . "\n";
                    exit();
                }
            }
        }

        else if ($role == 'Reviewer') {
            $insert_reviewer = " INSERT INTO reviewer
	(user_id,title,fname,lname,email,phone,affiliate_institution,snapshot,isClinician,isSecretary)
	VALUES (
	'$user_id', '$title', '$fname', '$lname', '$email', '$phone', '$affiliate_institution','$snapshot', '$isClinician', '$isSecretary')";
            try {
                mysqli_query($bd, $insert_reviewer);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->errorMessage() . "\n";
                exit();
            }
            if ($isClinician) { // reviewer can also be a clinician
                $insert_clinician = " INSERT INTO clinician
	(user_id,art_clinic,name,firstname,lastname,email,phone,isReviewer)
	VALUES (
	'$user_id', '$clin_art_clinic', '$this->fullname', '$fname', '$lname', '$email', '$phone', '$isReviewer')";
                try {
                    mysqli_query($bd, $insert_clinician);
                } catch (Exception $e) {
                    echo 'Caught exception: '. $e->errorMessage() . "\n";
                    exit();
                }            
            }
            if ($isSecretary) { // reviewer can also be a secretary
                $insert_secretary=" INSERT  INTO  secretary
	(user_id,fname,lname,email,phone)
	VALUES (
	'$user_id', '$fname', '$lname', '$email', '$phone')";
                try {
                    mysqli_query($bd, $insert_secretary);
                } catch (Exception $e) {
                    echo 'Caught exception: '. $e->errorMessage() . "\n";
                    exit();
                }            
            }
        }

        else if ($role == 'Secretary') {
            $insert_secretary=" INSERT  INTO  secretary
	(user_id,fname,lname,email,phone)
	VALUES (
	'$user_id', '$fname', '$lname', '$email', '$phone')";
            try {
                mysqli_query($bd, $insert_secretary);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->errorMessage() . "\n";
                exit();
            }            
        }

        else if ($role == 'Admin') {
                $insert_admin = " INSERT INTO admin
	(user_id,fname,lname,email,phone)
	VALUES (
	'$user_id', '$fname', '$lname', '$email', '$phone')";
            try {                
                mysqli_query($bd, $insert_admin);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->errorMessage() . "\n";
                exit();
            }              
        }

        else if ($role == 'Lab') {	
            $insert_pih_lab=" INSERT  INTO  pih_lab
	(user_id,fname,lname,email,phone)
	VALUES (
	'$user_id', '$fname', '$lname', '$email', '$phone')";
            try {                            
                mysqli_query($bd, $insert_pih_lab);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->errorMessage() . "\n";
                exit();
            }            
        }
        $this->id = $user_id;
    }

    public function Describe()
    {
        return "User: ".$this->fullname . " role is " . $this->role;
    }
}

/*
$c = new User(7);
echo "\n".$c->username;
echo "\n".$c->secretaryID;
echo "\n".$c->clinicianID;

$c = new User(37);
echo "\n".$c->username;
echo "\nfullname is ".$c->fullname;
echo "\nprimary role is " . $c->role . ', is reviewer? ' . $c->reviewer . ', is clinician? ' . $c->clinician . ', is secretary? ' . $c->secretary;
if ($c->clinician)
    echo "\nclinicianID is ".$c->clinicianID;
if ($c->reviewer)
    echo "\nreviewerID is ".$c->reviewerID;
echo "\n";

$c = new User('Reviewer11', 'passwd', 'Reviewer', 'Eleven', 'Reviewer', 'jgelbard@syzygydesigns.com', '+1265991339544', $isClinician=1, $isReviewer=0, $isSecretary=1, $title='Dr', $clin_art_clinic='', $affiliate_institution='Lighthouse');
echo "$c->id\n";
*/

class Application {
    public $patient;
    public $form_id;
    public $reviewers = [];
    public $rev_emails = [];
    public $lead_rev_id;
    public $lead_reviewer;
    
    public function __construct($id)
    {
        $bd = $GLOBALS['bd'];
        $enckey = $GLOBALS['enckey'];
        
        $other_reviewers_sql = "SELECT rev_id, title, fname, lname, email, status FROM assigned_forms, reviewer where form_id=$id and assigned_forms.rev_id = reviewer.id";

        $select_others = mysqli_query( $bd, $other_reviewers_sql);
        $other_reviewers = '';
        $email_to = '';
        while ($row_others = mysqli_fetch_array($select_others)) {
            $rev_id = $row_others['rev_id'];
            $other_reviewers[$rev_id] = ($row_others['title'].($row_others['title']?'. ':'').$row_others['fname'].' '.$row_others['lname']);
            $email_to[$rev_id] = $row_others['email'];
        }
        $this->reviewers = $other_reviewers;

        // get lead
        $select_lead = mysqli_query( $bd, "SELECT * FROM reviewer_team_lead WHERE form_id = '$id'" );
        while ($row_lead = mysqli_fetch_array($select_lead)) {
            $this->lead_rev_id = $row_lead['rev_id'];
            $this->lead_reviewer = new User($this->lead_rev_id, 'Reviewer');            
            break;
        }
        $patient_sql = "SELECT * FROM form_creation WHERE 3rdlineart_form_id = $id";
        $select_patient = mysqli_query( $bd, $patient_sql);
        while ($row_pat = mysqli_fetch_assoc($select_patient)) {
            $this->patient = new Patient($row_pat['patient_id']);
            break;
        }
    }

    public function lead_reviewer($which='name') {
        if ($which == 'name')
            return $this->lead_reviewer->fullname;
        if ($which == 'email')
            return $this->lead_reviewer->email;            
        if ($which == 'phone')
            return $this->lead_reviewer->phone;
        if ($which == 'id') {
            echo "<br>which is $which";
            return $this->lead_reviewer->id;
        }
    }
    
    public function other_reviewers($rev_id)
    {
        $other_reviewers = '';
        foreach($this->reviewers as $key => $reviewer) {
            if ($other_reviewers)
                $other_reviewers .= ', ';    
            if ($key != $rev_id)
                $other_reviewers .= $reviewer;
        }
        return $other_reviewers;
    }
}

// $app = new Application(6);
// echo "<br>lead reviewer is: ".$app->lead_reviewer();

class Facility {
    private $facilities = [];
    private $row_fac;
    
    public function __construct($id=0)
    {
        $bd = $GLOBALS['bd'];
        $enckey = $GLOBALS['enckey'];
        
        if ($id) 
            $query = "SELECT facilitycode, name FROM facilitys WHERE id = '$id'";
        else
            $query = "SELECT facilitycode, name FROM facilitys";
        $pat = mysqli_query($bd, $query); 
        while ($row_fac = mysqli_fetch_assoc($pat)) {
            $this->facilities[$row_fac['facilitycode']] = $row_fac['name'];
        }
    }

    public function facility($code)
    {
        return $this->facilities[$code];
    }
}

global $healthcenters;
$healthcenters = new Facility();

class Lab {
    public $address;
    public $manager;
    public $email;
    public $phone;
    private $row_lab;
    
    public function __construct($id=1)
    {
        $bd = $GLOBALS['bd'];
        $enckey = $GLOBALS['enckey'];
        
        if ($id) 
            $query = "SELECT * FROM pih_lab WHERE id = '$id'";
        else
            $query = "SELECT * from pih_lab";
        $pat = mysqli_query($bd, $query); 
        while ($row_lab = mysqli_fetch_assoc($pat)) {
            $this->manager = $row_lab['fname'].' '.$row_lab['lname'];
            $this->address = $row_lab['address'];
            $this->phone = $row_lab['phone'];
            $this->email = $row_lab['email'];            
            break;
        }
    }

    public function details() {
        return sprintf("<br>%s<br>%s,<br>email: %s<br>phone: %s", $this->manager, $this->address, $this->email, $this->phone);
    }
}    

global $lab;
$lab = new Lab();

// echo "\nlab is ".$lab->manager;
// echo "\naddress is ".$lab->address;

class Patient {
    public $fullname;
    public $firstname;
    public $lastname;
    public $age;
    public $dob;
    public $gender;
    public $art_id_num;
    public $pat_art_clinic;
    public $vl_sample_id;
    public $date_created;
    public $enc;
    public $id;
    
    private $row_pat;
    public function __construct($id, $id_type='patient')
    {
        $bd = $GLOBALS['bd'];
        $enckey = $GLOBALS['enckey'];
        
        // echo "my key: $enckey";
        if ($id_type == 'patient') 
            $query = "SELECT * FROM patient WHERE id = '$id'";
        else if ($id_type == 'form')
            $query = "SELECT p.* FROM patient p INNER JOIN form_creation fc on p.id = fc.patient_id WHERE fc.3rdlineart_form_id = '$id'";

        $pat = mysqli_query($bd, $query); 
        $row_pat = mysqli_fetch_assoc($pat);
        $enc = $row_pat['enc'];

        $this->id = $id;
        $this->pat_art_clinic = $enc ? decrypt($row_pat['pat_art_clinic'], $enckey) : $row_pat['pat_art_clinic'];
        $this->art_id_num = $enc ? decrypt($row_pat['art_id_num'], $enckey) : $row_pat['art_id_num'];
        $this->art_id_num_ref = $enc ? decrypt($row_pat['art_id_num_ref'], $enckey) : $row_pat['art_id_num_ref'];

        $this->firstname = ($enc == 1) ? decrypt($row_pat['firstname'], $enckey) : $row_pat['firstname'];
        $this->lastname = $enc ? decrypt($row_pat['lastname'], $enckey) : $row_pat['lastname'];
        $this->date_created = $row_pat['date_created'];
        
        // echo $this->firstname.' '.$this->lastname;
        $this->gender = $row_pat['gender'];
        $this->dob = $row_pat['dob'];
        $this->vl_sample_id = $row_pat['vl_sample_id'];
        $this->fullname = $this->firstname." ".$this->lastname;
        
        $this->age = getAge($this->dob);

        // DONT HAVE THESE YET!
        // $this->email = $row_pat['email'];
        // $this->phone = $row_pat['phone'];        
        $this->enc = $enc;
        $this->row_pat = $row_pat;        
    }
    
    public function Describe()
    {
        return $this->fullname . " is " . $this->age . " years old";
    }
    
    public function getProp($prop='') {
        if ($prop == '')
            return $this->row_pat;
        else
            return ($this->row_pat)[$prop];
    }

    public function getFullname() {
        return $this->fullname;
    }
  
    public function getConsReviews2($clinicianID, $formmID) {
        $query = "SELECT * FROM patient, form_creation, expert_review_consolidate2 WHERE form_creation.3rdlineart_form_id=expert_review_consolidate2.form_id and form_creation.clinician_id ='$clinicianID' and form_creation.patient_id=patient.id and expert_review_consolidate2.form_id ='$formID' ORDER BY `form_creation`.`3rdlineart_form_id` DESC";
        return mysqli_query($this->$bd, $query); 
    }
}

// $p = new Patient(6);

/*
./includes/app_consolidated2_view.php:12:$form_creation=mysqli_query( $bd,"SELECT * FROM patient, form_creation, expert_review_consolidate2 WHERE  form_creation.3rdlineart_form_id=expert_review_consolidate2.form_id and form_creation.clinician_id ='$clinicianID' and form_creation.patient_id=patient.id and expert_review_consolidate2.form_id ='$formID' ORDER BY `form_creation`.`3rdlineart_form_id` DESC"); 

./includes/db_operations/insert_patient.php:18:    $check_patient=mysqli_query( $bd,"SELECT * FROM patient where art_id_num='$art_id_num' "); 

./includes/app_consolidated1_view.php:11:$form_creation=mysqli_query( $bd,"SELECT * FROM patient, form_creation, expert_review_consolidate1 WHERE  form_creation.3rdlineart_form_id=expert_review_consolidate1.form_id and form_creation.clinician_id ='$clinicianID' and form_creation.patient_id=patient.id and expert_review_consolidate1.form_id ='$formID' ORDER BY `form_creation`.`3rdlineart_form_id` DESC"); 

../includes/app_clinic_status_edit.php:147:$patient_side_effects=mysqli_query( $bd,"SELECT * FROM patient_side_effects where patient_id='$pat_id' ");

./pih/includes/lab_sample.php:23:       $patient=mysqli_query( $bd,"SELECT * FROM patient,form_creation where patient.id=form_creation.patient_id and form_creation.3rdlineart_form_id='$formid' "); 

./includes/db_operations/update_clinic_status.php:90:   $insert_pat_side_effect="INSERT INTO patient_side_effects (patient_id,PeripheralNeuropathy,Jaundice,Lipodystrophy,KidneyFailure,Psychosis,Gynecomastia,Anemia,other)

./includes/db_operations/insert_clinic_status.php:82:// echo(" INSERT  INTO patient_side_effects (patient_id,PeripheralNeuropathy,Jaundice,Lipodystrophy,Psychosis,Gynecomastia,Anemia,other) VALUES ('$patient_id', '$Jaundice', '$Lipodystrophy', '$KidneyFailure', '$Psychosis', '$Gynecomastia','$Anemia','$other')");

./includes/db_operations/insert_clinic_status.php:84:$insert_pat_side_effect=" INSERT  INTO patient_side_effects (patient_id,PeripheralNeuropathy,Jaundice,Lipodystrophy,KidneyFailure,Psychosis,Gynecomastia,Anemia,other)
./includes/db_operations/insert_patient.php:23:$insert_patient=" INSERT  INTO patient(pat_art_clinic,art_id_num,firstname,lastname,gender,dob,vl_sample_id, date_created)

./includes/db_operations/update_patient.php:16:$sql_update_patient = "UPDATE patient
      
./includes/db_operations/update_clinic_status.php:124:  $sql_update_patient = "UPDATE patient 
*/

$cp_query = [
    'select_assigned_forms' => "SELECT distinct form_id FROM assigned_forms 
         WHERE form_id not in (select form_id from expert_review_consolidate1) 
         ORDER BY `assigned_forms`.`form_id` DESC",
    'select_new_forms' => "SELECT * FROM form_creation 
         WHERE status='Complete' and complete !='Rejected' 
         ORDER BY `form_creation`.`3rdlineart_form_id` DESC ",
    'select_expert_review_consolidate1' => "SELECT * FROM expert_review_consolidate1 
         ORDER BY `expert_review_consolidate1`.`id` DESC ",
    'select_sec_pending_sample' => "SELECT * FROM expert_review_consolidate1 
         WHERE genotyping='Yes' and form_id not in (select form_id from sample) ORDER BY `expert_review_consolidate1`.`id` DESC ",
    'select_sec_pending_results' => "SELECT * FROM form_creation, lab_vl_repeat 
         WHERE form_id not in (select form_id from app_results) and form_creation.3rdlineart_form_id=lab_vl_repeat.form_id ORDER BY `form_creation`.`3rdlineart_form_id` DESC",
    'select_sec_results_under_review' => "SELECT distinct form_id,date_assigned 
         FROM assigned_app_results WHERE form_id not in (select form_id from expert_review_consolidate2) ORDER BY `assigned_app_results`.`form_id` DESC",
    'select_sec_reviewed_results' => "SELECT * FROM expert_review_consolidate2 ORDER BY `expert_review_consolidate2`.`id` DESC ",
];

$rev_query = [
'select_forms_new' => "SELECT * FROM assigned_forms where rev_id='%s' and status ='Not Reviewed'",
'select_assigned_forms_lead' => "SELECT distinct form_id,date_assigned FROM assigned_forms WHERE form_id in (select form_id from reviewer_team_lead where reviewer_team_lead.rev_id=%s) and form_id not in (select form_id from expert_review_consolidate1) ORDER BY `assigned_forms`.`form_id` DESC",
'select_form_my_reviews' => "SELECT * FROM assigned_forms where rev_id='%s' and status = 'Reviewed'",
'select_all_reviews' => "SELECT * FROM assigned_forms where status = 'Reviewed'",
'select_form_assigned_app_results' => "SELECT * FROM assigned_app_results where rev_id='%s' and status ='Not Reviewed'",
'select_lead_assigned_forms' => "SELECT distinct form_id,date_assigned FROM assigned_app_results WHERE form_id in (select form_id from reviewer_team_lead2 where reviewer_team_lead2.rev_id='%s') and form_id not in (select form_id from expert_review_consolidate2) ORDER BY `assigned_app_results`.`form_id` DESC"
];

$lab_query = [
];

$admin_query = [
    'select_drugs' => 'SELECT * FROM drugs',
    'select_facilitys' => 'SELECT * FROM facility',
    'select_affiliates' => 'SELECT * FROM partner_org',
    'select_rev' => 'SELECT * FROM reviewer where linked <> 1',
    'select_clinician' => 'SELECT * FROM clinician where linked <> 1',
    'select_labs' => 'SELECT * FROM pih_lab',
    'select_sec' => 'SELECT * FROM secretary where linked <> 1',
    'select_admin' => 'SELECT * FROM admin',
    'select_apps' => 'SELECT * FROM patient',    
];

$main_query = [
];

global $user_id;
$clinician_query = [
    'app_new_referralx' => "SELECT * FROM form_creation, expert_review_consolidate1 WHERE form_creation.3rdlineart_form_id not in (select form_id from sample) and form_creation.3rdlineart_form_id=expert_review_consolidate1.form_id and form_creation.clinician_id ='%s'",
    'app_incomplete_referral' => "SELECT * FROM form_creation where (status='Not Complete' or complete ='Rejected') and clinician_id='%s' ORDER BY `form_creation`.`3rdlineart_form_id` DESC ",
    'app_total' => "SELECT * FROM form_creation WHERE clinician_id = '%s' and status != 'Not Complete'",
    'app_rejected' => "SELECT * FROM form_rejected,form_creation WHERE form_creation.3rdlineart_form_id = form_rejected.form_id and form_creation.clinician_id ='%s'",
    'app_refer_decisions' => "SELECT * FROM form_creation, expert_review_consolidate1 WHERE form_creation.3rdlineart_form_id not in (select form_id from sample) and form_creation.3rdlineart_form_id=expert_review_consolidate1.form_id and form_creation.clinician_id ='%s'", 
    'app_refer_decisions_complete' => "SELECT * FROM form_creation, expert_review_consolidate1 WHERE form_creation.3rdlineart_form_id in (select form_id from sample) and form_creation.3rdlineart_form_id=expert_review_consolidate1.form_id and form_creation.clinician_id ='%s'", 
    'app_refer_decisions_wrong' => "SELECT * FROM form_creation, expert_review_consolidate2 WHERE form_creation.3rdlineart_form_id=expert_review_consolidate2.form_id and form_creation.clinician_id ='%s'",
    'app_genotype_res' => "SELECT * FROM form_creation, expert_review_consolidate2 WHERE form_creation.3rdlineart_form_id=expert_review_consolidate2.form_id and form_creation.clinician_id ='%s'"
];


/*
$p = new Patient(384);
echo "\n".$p->getFullname()."\n".$p->fullname."\n";
echo $p->getProp('dob').' age: '.$p->age."\n";

$arr = ['one', 'two', 'three'];
list($a, $b, $c) = $p->getProp();
echo "\n$a";
echo "\n$b";
echo "\n$c";
*/

// $p = new Patient(267, 'form');
/*
$select_patients = "SELECT * FROM patient";
$patients = mysqli_query($bd, $select_patients);
while ($row = mysqli_fetch_array($patients)) {
    echo "id: ".$row['id'];
    $p = new Patient($row['id']);
    echo "*********** ".$p->getProp('firstname').' '.$p->getProp('lastname').' '.$p->getProp('pat_art_clinic').' '.$p->pat_art_clinic;
echo "\n";
}

$p = new Patient(410);
echo $p->getProp('firstname').' '.$p->getProp('lastname').' '.$p->getProp('pat_art_clinic').' '.$p->pat_art_clinic;
// list($id, $clinic, $art_id_num, $firstname, $lastname, $gender, $dob, $vl_sample_id, $date_created) = $p->getProp();  // order dependent (but concise)
// echo "id: $id, art_clinic: $clinic, $art_id_num, fn: $firstname, ln: $lastname, g: $gender, dob: $dob, samp: $vl_sample_id, created: $date_created";
// echo "<br>".$p->firstname." ".$p->lastname.": ".$p->gender.", age: ".$p->age.", art_clinic: ".$p->pat_art_clinic;
// testClass(411);
*/
?>