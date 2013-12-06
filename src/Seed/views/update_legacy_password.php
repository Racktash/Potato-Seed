<?php
if (BOOT != "yes")
    exit();

$val_errors = $controller_object->getValidationErrors();
$legacy_password = $controller_object->getLegacyPassword();
$username = $controller_object->getUsername();

foreach($val_errors as $error)
{
    ?>



<div class='msgBad'><?php echo $error; ?></div>



    <?php
}

?>

<p>
	Your password has expired. Please update it.
</p>

<form action='login.php' method='post'>


    <p><strong>Username</strong><input type='text' name='username' value='<?php echo $username; ?>'></p>
    <p><strong>New Password</strong><input type='password' name='newpassword1'></p>
    
    <input type='hidden' name='passer' value='PASS2'>
    <input type='hidden' name='password' value='<?php echo $legacy_password; ?>'>
    
    <p><strong>New Password (Confirm)</strong><input type='password' name='newpassword2'></p>
    
    <p><input type='submit' value='Update'></p>
    
</form>
