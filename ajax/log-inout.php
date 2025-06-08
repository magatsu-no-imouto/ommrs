<?php
include('./../functions/auth');
$x=$_GET['which'];

function door($which){
    if($which=='login' && (!empty($_POST['username']) && !empty($_POST['password']))){
        return login([$_POST['username'],$_POST['password']]);
    }
}
echo $door;
?>