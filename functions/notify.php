<?php
require './../helpers/phpmailer/src/Exception.php';
require './../helpers/phpmailer/src/PHPMailer.php';
require './../helpers/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//likely used in conjunction with auth.php--which has $conn to scour the database.

//For testing purposes, we'll be using the RSTA one. Hopefully we can appeal for a separate email once we get this thing fully operational.
function setMail(){
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'mail.hayakawa.com.ph';
        $mail->SMTPAuth = true;
        $mail->Username = 'rsta@hayakawa.com.ph';
        $mail->Password = 'HK6Uzn1DCuW1kbhsvJI9';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->isHTML(true);
        return $mail;
}

function msgBuilder($x,$y,$z,$a='reasons unspecified'){
    //$x is message type
    //$y is uDisplayName
    //$z is reservation deets
    //$a is misc details--mainly rejection or cancellation notifs
    global $today;
    $header='Room Reservation';
    $subject="[".$z['id']."]";
    $z1=datetime::createFromFormat('Y-m-d H:i',$z['meetingDate']['start']);
    $za=$z1->format('Y-m-d h:i A');
    $z2=datetime::createFromFormat('H:i',$z['meetingDate']['end']);
    $zb=$z2->format('Y-m-d h:i A');
    $testTag='<h1 style="color:red"><strong>[THIS IS A DUMMY MESSAGE! PLEASE DISREGARD ITS CONTENTS]</strong></h1>';
    $msg=$today->format('m/d/Y h:i:a')."<br><br>".$testTag;
    $msg.="Dear User, We would like to inform you that the reservation for ".$z['room']." that ".$z['reservedBy']." has requested for the meeting at ".$za;
    if($x=='new'){
        $subject.=' NEW RESERVATION';
        $msg=$today->format('m/d/Y h:i:a')."<br><br>".$testTag;
        $msg.='Dear Admin, we would like to inform you that there is a new '.$z['meetingLevel'].' Type Request for a room reservation submitted';

    }else if($x=='approved'){
        $subject.=' RESERVATION APPROVED';
        $msg.=' has been approved by the admin in charge. Please be reminded to start and end within the alloted timeframe, as well as to ensure the cleanliness of the room afterwards.<br><br>';
    }else if($x=='invitation'){
        $subject='MEETING @ '.$z['room'];
        $msg='Good day!<br><br>You are invited to participate in a '.$z['meetingLevel'].' meeting at '.$z['room'].' from '.$za.' to '.$zb.'';
    }else if($x=='rejected'){
        $subject.=' RESERVATION REJECTED';
        $msg.=' has been rejected by the admin in charge due to '.$a.'<br><br>We would like to encourage you to place another request for another time when it is available to.<br><br><br><br><i>Thank you for your cooperation.</i><br><br>Best regards,<br>Frontdesk<br><br><br>';
        return [$header,$subject,$msg];   
    }else if($x=='cancelled'){
        $subject.=' RESERVATION CANCELLED';
        $msg.=' has been cancelled due to '.$a.'.<br><br>We sincerely apologize for the inconvenience this may have caused. We would like to encourage you to place another request for another time when the participants are available to meet at another room.<br><br><br><br><i>Thank you for your cooperation.</i><br><br>Best regards,<br>Frontdesk<br><br><br>';
        return [$header,$subject,$msg];   
    }else if($x=='cancellation'){
        $subject='MEETING CANCELLED';
        $msg.=' has been cancelled due to '.$a.'.<br><br>We sincerely apologize for the inconvenience this may have caused.<br><br><br><br><i>Thank you for your cooperation.</i><br><br>Best regards,<br>Frontdesk<br><br><br>';
        return [$header,$subject,$msg];   
    }else{
        return "ERROR! Message Type not found!";
    }
        $msg.='Below are the details of the Reservation:<br><br><strong>Reservation ID:</strong>:'.$z['id'].'<br><br>';
        $msg.='<strong>Room</strong>:'.$z['room'].'<br><br>';
        $msg.='<strong>Priority</strong>:'.$z['meetingLevel'].'<br><br>';
        $msg.='<strong>Meeting Date</strong>:'.$za.' ~ '.$zb.'<br><br>';
        $msg.='<strong>Purpose:</strong>'.$z['purpose'].'<br><br>';
        $msg.='<strong>Attendants</strong>:<br><br>';
        foreach($z['attendants'] as $zx){
            $msg.=$zx['name'].'<br>';
        }

        $msg.='<br><strong><i>Your prompt attention to this matter is highly appreciated.</i></strong><br><br>Thank you for your cooperation.</i><br><br>Best regards,<br>Frontdesk<br><br><br>';
        return [$header,$subject,$msg];   
}


function nEmail($x,$y,$z=''){
    global $conn;
    $u=fetchUsers();
    $res=fetchReservations();
    $res=$res[$x];
    $f=$u[$res['reservedBy']];
    //$x reservation ID
    //$y message type
    //$z misc details
    $mail=setMail();
    $mail->addAddress($f['email']);
    if($y=='invitation'){
        $sent=[];
        foreach($res['attendants'] as $r){
        $email = strtolower(trim($r['email'] ?? ''));

        if (empty($email) || isset($sent[$email])) {
            continue;
        }

        $mail->addAddress($r['email']);
        $sent[$email] = true;
        }
    }else{
        #$mail->addAddress(insert admin email here);
    }
    $msg=msgBuilder($y,$f['FullName'],$res,$z);
    $userEmail = 'rsta@hayakawa.com.ph';
    $userName=$msg[0];
    $subject=$msg[1];
    $body=$msg[2];
    $mail->setFrom($userEmail, $userName);
    $mail->Subject = $subject;
    $mail->Body = $body;
    if ($mail->send()) {
        $no++;
        $mail->clearAddresses();
        $mail->clearAttachments();
        return true;
    }
}

function nEmailAdmin($x,$y){
    global $conn;
    $u=fetchUsers();
    $res=fetchReservations();
    $res=$res[$x];
    $f=$u[$res['reservedBy']];
    //$x reservation id
    //$y message type
    $mail=setMail();
    #$mail->addAddress($u['admin']['email']);
    $mail->addAddress($u['ticman']['email']);
    $msg=msgBuilder($y,$f['FullName'],$res);
    $userEmail = 'rsta@hayakawa.com.ph';
    $userName=$msg[0];
    $subject=$msg[1];
    $body=$msg[2];
    $mail->setFrom($userEmail, $userName);
    $mail->Subject = $subject;
    $mail->Body = $body;
    if ($mail->send()) {
        $mail->clearAddresses();
        $mail->clearAttachments();
        return true;
    }
}

?>
