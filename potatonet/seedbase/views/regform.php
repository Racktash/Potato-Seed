<?php
if (BOOT != "yes")
    exit();

$val_errors = $controller_object->returnValidationErrors();
?>

<?php

foreach($val_errors as $error)
{
    ?>
<div class='msgBad'><?php echo $error; ?></div>
    <?php
}

?>

<form action='register.php' method='POST'>
    <p><strong>Desired Username:</strong><input type='text' name='username'></p>
    <p><strong>E-mail Address:</strong><input type='email' name='email'></p>
    <input type='hidden' name='passer' value='PASS'>
    <p><strong>Password:</strong><input type='password' name='pass1'></p>
    <p><strong>Password (repeat):</strong><input type='password' name='pass2'></p>
    
    <p><strong><?php echo REGISTRY_SPAM_QUESTION; ?> :</strong><input type='text' name='spam'></p>
    
    <p><input type='submit' value='Register'></p>
</form>