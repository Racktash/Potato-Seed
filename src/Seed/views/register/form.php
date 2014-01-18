<?php
if (BOOT != "yes")
    exit();

$val_errors = $controller->getValidationErrors();
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
    <p><strong>Password:</strong><input type='password' name='password1'></p>
    <p><strong>Password (repeat):</strong><input type='password' name='password2'></p>
    
    <p><strong><?php echo REGISTRY_SPAM_QUESTION; ?> :</strong><input type='text' name='spam'></p>
    
    <p><input type='submit' name="submit" value='Register'></p>
</form>
