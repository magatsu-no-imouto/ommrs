<?php
//to call= action='./ajax/x-insertForm.php?which=X' replace X with 'request' or 'account';
//ajax response/end point for insert functions.
include('./../functions/auth.php');
include('./../functions/dbFunctions.php');
//a surprise tool for later VVV
include('./../functions/notify.php');

$x=$_GET['which'];

function insertDB($which){
    global $today;
    switch($which){
        case 'account': 
            if(empty($_POST['fullname']) || empty($_POST['department']) || empty($_POST['email']) || empty($_POST['password']) ||empty($_POST['fullname']) || empty($_POST['confirm'])){
            return "NO";    
            }
            if($_POST['password'] != $_POST['confirm']){
                echo "ERROR: PASSWORD IS NOT THE SAME";
                return;
            }
        $input=[
            'uName'=>$_POST['username'],
            'uDept'=>$_POST['department'],
            'uEmail'=>$_POST['email'],
            'uPass'=>$_POST['password'],
            'uType'=>"Employee",
            'uDisplayName'=>$_POST['fullname']
        ];
            return insertR($input,'users');
        case 'request':
            if(empty($_POST['resRoom']) || empty($_POST['resMeetDate']) || empty($_POST['resMeetStart']) || empty($_POST['resMeetEnd']) || empty($_POST['resPurpose']) || empty($_POST['resType']) || empty($_POST['attdCount'] || empty($_POST['resRequirements']))){
                return 'NO';
            }
            $attd=[];
            for($x=1;$x<=$_POST['attdCount'];$x++){
                $attd[]=[
                    "name"=>$_POST['attendantName'.$x],
                    "email"=>$_POST['attendantEmail'.$x]
                ];
            }
            $resMeet=[
                "start"=>$_POST['resMeetDate'].' '.$_POST['resMeetStart'],
                "end"=>$_POST['resMeetDate'].' '.$_POST['resMeetEnd']
            ];
            $resID=count(fetchReservations());
            $input=[
                "resID"=>$resID,
                "resMeet"=>json_encode($resMeet),
                "resAttendants"=>json_encode($attd),
                "resUser"=>'ticman',#once the login and home pages are done, Imma replace this $_SESSION['username']
                "resType"=>$_POST['resType'],
                "resRoom"=>$_POST['resRoom'],
                "resDate"=>$today->format('Y-m-d H:i:s'),
                "resPurp"=>$_POST['resPurpose'],
                "resReq"=>$_POST['resRequirements'],
                "resStatus"=>"PENDING"
            ];
            if(insertR($input,'reservation')){
                return nEmailAdmin($input['resID'],'new');
            }
        default:
            return 'ERROR';
    }
}
echo insertDB($x);
?>