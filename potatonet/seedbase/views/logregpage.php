<?php
if(BOOT != "yes")
    exit();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo pdisplay($controller_object->returnPageTitle()); ?></title>
    </head>
    <body>
        <?php
            require(REGISTRY_SEEDBASE_PATH."views/".$controller_object->returnInnerView());
        ?>
    </body>
</html>