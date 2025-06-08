<?php
//include this baybe alongside auth.php in order to use the functions in it.(assuming you're running with php)

//fetching reservations in an array to be accessed via IDs--could be accessed via loop
//ie. $u=fetchUsers(); $u[$_POST['resUser']]['FullName'];
function fetchReservations($f=''){
    global $conn;
    $w='';#where r.resType=?
    if($f!=''){
        $w='WHERE r.resType=?';
    }
    $sql='SELECT r.*, rm.* FROM reservation r INNER JOIN room rm ON rm.roomID = r.resRoom'.$w;
    $stmt=$conn->query($sql);
    if(!$stmt){
    return "Query error: " . $conn->error;
    }
    $x=[];
    if($stmt->num_rows>0){
    while($row=$stmt->fetch_assoc()){
        $x[$row['resID']]=[
            'id'=>$row['resID'],
            "room"=>$row['roomName'],
            "reservedBy"=>$row['resUser'],
            "meetingLevel"=>$row['resType'],
            "reservationDate"=>$row['resDate'],
            "meetingDate"=>json_decode($row['resMeet'],true),
            "purpose"=>$row['resPurp'],
            "attendants"=>json_decode($row['resAttendants'],true),
            "requirements"=>$row['resReq'],
            "status"=>$row['resStatus']
        ];
    }
}
    return $x;
}


//fetching user accounts in an array to be accessed via usernames--could be accessed via loop
function fetchUsers(){
    global $conn;
    $sql='SELECT * FROM users';
    $stmt=$conn->query($sql);
    if(!$stmt){
    return "Query error: " . $conn->error;
    }
    $x=[];
    if($stmt->num_rows>0){
    while($row=$stmt->fetch_assoc()){
        $x[$row['uName']]=[
            'username'=>$row['uName'],
            "department"=>$row['uDept'],
            "email"=>$row['uEmail'],
            "password"=>$row['uPass'],
            "userType"=>$row['uType'],
            "FullName"=>$row['uDisplayName']
        ];
        }
    }
    return $x;
}

function fetchDivSects(){
    global $conn;
    $sql='SELECT * FROM divsections';
    $stmt=$conn->query($sql);
    if(!$stmt){
    return "Query error: " . $conn->error;
    }
    $x=[];
    if($stmt->num_rows>0){
    while($row=$stmt->fetch_assoc()){
        $x[$row['divSecId']]=[
           "id"=>$row['divSecId'],
           "name"=>$row['divSecName']
        ];
        }
    }
    return $x;
}

//fetching rooms in an array to be accessed via IDs--could be accessed via loop
function fetchRoom(){
    global $conn;
    $sql='SELECT * FROM room';
    $stmt=$conn->query($sql);
    if(!$stmt){
    return "Query error: " . $conn->error;
    }
    $x=[];
    if($stmt->num_rows>0){
    while($row=$stmt->fetch_assoc()){
        $x[$row['roomID']]=[
            'id'=>$row['roomID'],
            "name"=>$row['roomName']
        ];
        }
    }
    return $x;
}


//generalist insert function
function insertR($x,$y){
    //$x - input, array. ['columnName'=>'value']
    //$y - table
    global $conn;
    $fa=[];
    $fb=[];
    $fc=[];
    foreach($x as $xa=>$xb){
        $fa[]="`".$xa."`";
        $fb[]="?";
        $fc[]=$xb;
    }
    $setA=implode(',',$fa);
    $setB=implode(',',$fb);
    $sql='INSERT INTO '.$y.'('.$setA.') VALUES('.$setB.')';
    $stmt=$conn->prepare($sql);
    if(!$stmt){
        echo "PREPARATION ERROR:".$conn->error;
        return;
    }
    $types=str_repeat('s',count($fc));
    $stmt->bind_param($types,...$fc);
    if(!$stmt->execute()){
        echo $stmt->error;
        return;
    }else{
        return true;
    }
}

//generalist update function
function updateR($x,$y,$z){
    global $conn;
    //$x - input, array. ['columnName'=>'value']
    //$y - table
    //$z - existing id array 
    $fa=[];
    $fb=[];
    $fID=[
        'reservation'=>'resID',
        'room'=>'roomID',
        'users'=>'uName'
    ];
    foreach($x as $xa=>$xb){
        $fa[]='`'.$xa.'`=?';
        $fb[]=$xb;
    };
    $fb[]=$z;
    $set=implode(',',$fa);
    $sql='UPDATE '.$y.' SET '.$set.' WHERE '.$fID[$y].'=?';
    $types=str_repeat('s',count($fb));
    $stmt=$conn->prepare($sql);
    if(!$stmt){
        return "PREPARATION ERROR: ".$conn->error;
    }
    $stmt->bind_param($types,...$fb);
    if(!$stmt->execute()){
        return "ERROR: ".$stmt->error;
    }else{
        return true;
    }
};

function checkResDate(){
    //compares today with the datetime of reservation
    global $conn,$today;
    $res=fetchReservations();
    foreach($res as $x){
        $dtFr=$x['meetingDate'][0];
        $dtF=datetime::createFromFormat('Y-m-d H:i:s');
        if($today>$dtF && ($x['status']!='IN PROGRESS' && $x['status']!='COMPLETED')){
            $input=[
                'resStatus'=>"LATE"
            ];
            updateR([$input],"reservation",$x['id']);
        }
    }
}

//drop reservations due to it being time based.
function dropRes($x){
    //$x reservation ID
    global $conn;
    $sql='DELETE FROM reservation WHERE resID=?';
    $stmt=$conn->prepare($sql);
    if(!$stmt){
        return "PREPARATION ERROR: ".$conn->error;
    }
    $stmt->bind_param('s',$x);
    if(!$stmt->execute()){
        return "ERROR: ".$stmt->error;
    }else{
        return true;
    }

}

?>