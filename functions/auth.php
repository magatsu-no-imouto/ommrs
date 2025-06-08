<?php
$user = "root";
$pass = "";
$db = "ommrsys";

$conn = new mysqli('localhost', $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();


$timezone = new DateTimeZone('Asia/Manila'); // or whatever your local zone is
$today = new DateTime('now', $timezone);
$now=$today->format('Y-m-d');
$uN='';

#call me on page where login credentials should be saved.
function checkLog(){
    if (!isset($_SESSION['loggedin']) || empty($_SESSION['username']) || $_SESSION['loggedin'] !== true) {
     if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
        header("Location: /ommrs/login.php");
        exit;
    }
    }else{
    $uN=$_SESSION['username'];
    $uType=$_SESSION['type'];
}
}

function login($x){
    global $conn;
    print_r($x);
    $sql="SELECT * FROM `users` WHERE `uName`=? AND `uPass`=?";
    $stmt=$conn->prepare($sql);
    if (!$stmt) {
        return "Prepare failed: " . $conn->error;
    }
    $hashed=sha1($x[1]);
    $stmt->bind_param('ss',$x[0],$hashed);
    if(!$stmt->execute()){
        return "ERROR: " . $stmt->error;
    }
    $res=$stmt->get_result();
    echo $res->num_rows;
    if($res->num_rows>0){
        $d=$res->fetch_assoc();
        $_SESSION['loggedin']=true;
        $_SESSION['username']=$d['uName'];
        $_SESSION['type']=$d['uType'];
        return true;
    }else{
        return false;
    }
}

?>