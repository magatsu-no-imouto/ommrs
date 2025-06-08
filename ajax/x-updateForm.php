<?php
include('./../functions/auth.php');
include('./../functions/dbFunctions.php');
$x=$_GET['which'];

function updateDB($which){
    global $today;
    switch($which){
        case 'approve':
            if(updateR(['resStatus'=>'APPROVED'],'reservation',$_POST['resID'])){
                nEmail('approval',$_POST['resID']);
                return nEmail('invitation',$_POST['resID']);
            }
        case 'reject':
            if(updateR(['resStatus'=>'REJECTED'],'reservation',$_POST['resID'])){
                return nEmail('rejection',$_POST['resID'],$_POST['rejectionDetails']);
            }
        case 'cancel':
            if(updateR(['resStatus'=>'CANCELLED'],'reservation',$_POST['resID'])){
                nEmail('cancelled',$_POST['resID'],$_POST['cancellationDetails']);
                return nEmail('cancellation',$_POST['resID'],$_POST['cancellationDetails']);
            }
        default:
        return "ERROR!";
    }
}

echo updateDB($x);

?>