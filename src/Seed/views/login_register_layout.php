<?php
if(BOOT != "yes")
    exit();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo display\html($controller->getPageTitle()); ?></title>
    </head>
    <body>
        <?php
            require(REGISTRY_ENGINE_PATH."views/".$controller->getInnerView());
        ?>
    </body>
</html>
