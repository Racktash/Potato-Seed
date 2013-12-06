<?php
if(BOOT != "yes")
    exit();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo display\html($controller_object->getPageTitle()); ?></title>
    </head>
    <body>
        <?php
            require(REGISTRY_ENGINE_PATH."views/".$controller_object->getInnerView());
        ?>
    </body>
</html>
