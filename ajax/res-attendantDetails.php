<?php
$no=$_GET['no'];

for($x=1;$x<=$no;$x++):
?>
<div class='row <?=($x>1)?'mt-1':''?>'>
    <div class='col'>
        <label class='form-label'>Name</label>
        <input name='attendantName<?=$x?>' class='form-control'>
    </div>
    <div class='col'>
        <label class='form-label'>Email</label>
        <input name='attendantEmail<?=$x?>' class='form-control'>
    </div>
</div>
<?php endfor?>