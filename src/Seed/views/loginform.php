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


<form action='login.php' method='post'>

    <p><strong>Username</strong><input type='text' name='username'></p>
    
    <input type='hidden' name='passer' value='PASS'>
    
    <p><strong>Password</strong><input type='password' name='password'></p>
    
    <p><input name='submit' type='submit' value='Log In'></p>
    
</form>
