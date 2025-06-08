<?php
include('./functions/auth.php');
include('./functions/dbFunctions.php');
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
    </style>
    <body>
<!----->
        <form method='POST' id='fomm' action='./ajax/x-insertForm.php?which=request'>
            <label class='form-label'>Room</label>
            <select name='resRoom' class='form-select'>
                <option></option>
                <?php foreach($room as $rm):?>
                    <option value='<?=$rm['id']?>'><?=$rm['name']?></option>
                <?php endforeach?>
            </select>
            <label class='form-label'>Date of Meeting</label>
            <input class='form-control' name='resMeetDate' type='date'>
            <div class='row'>
                <div class='col'>
                    <label class='form-label'>Start:</label>
            <input class='form-control' name='resMeetStart' type='time'>
                </div>
                <div class='col'>
                    <label class='form-label'>End:</label>
            <input type='time' name='resMeetEnd' class='form-control'>
                </div>
            </div>
            <label class='form-label'>Reason for Meeting</label>
            <textarea name='resPurpose' class='form-control' type='text-area'></textarea>
            <label class='form-label'>Meeting Type</label>
            <select name='resType' class='form-select' required>
                <option></option>
                <option value='regular'>Regular</option>
                <option value='customer'>Customer</option>
                <option value='executive'>Executive</option>
            </select>
            <label class='form-label'>attendants</label>
            <div class='row'>
                <div class='col-2'>    
            <input class='form-control' oninput='addAttd(this.value)' type='number' id='noAttd' name='attdCount' value=1>
                </div>
            <div class='col'>
                <div class='container' id='attd'>
                </div>
            </div>
            </div>
            <label class='form-label'>Special Requirements</label>
            <textarea name='resRequirements' class='form-control' type='text-area'></textarea>
            <button name='sub' class='btn btn-success mt-1'>SUBMIT</button>
        </form>
    </body>
    <script>
        document.getElementById('fomm').addEventListener('submit',function(e){
        e.preventDefault();
        const fomData=new FormData(this);
        fetch(this.action,{
            method:this.method,
            body:fomData
        }).then(response => response.text())
        .then(data => {
            console.log(data);
            if(data=='1'){
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    })
    document.addEventListener('DOMContentLoaded',function(){
        x=document.getElementById('noAttd').value;
        fetch(`./ajax/res-attendantDetails.php?no=${x}`)
        .then(response=>response.text())
        .then(data=>{
            document.getElementById('attd').innerHTML='';
            document.getElementById('attd').innerHTML=data;
        })
    })

    function addAttd(x){
        fetch(`./ajax/res-attendantDetails.php?no=${x}`)
        .then(response=>response.text())
        .then(data=>{
            document.getElementById('attd').innerHTML='';
            document.getElementById('attd').innerHTML=data;
        })
    }
    </script>
</html>