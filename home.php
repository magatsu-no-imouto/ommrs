<?php
include('./functions/auth.php');
include('./functions/dbFunctions.php');
echo "hi ho login worked yo";
$room=fetchRoom();
?>
<html>
    <head>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome for social media icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
    <style>
        .ui{
            cursor: pointer;
        }
        .ui:hover{
            background-color:red;
        }
    </style>
    <body>
        <div class='row'>
            <?php foreach($room as $rm):?>
            <div class='col ui'><?=$rm['name']?></div>
            <?php endforeach?>
            </div>
    </body>
</html>