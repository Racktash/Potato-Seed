<?php
//Load Ordered Classes
# Load the classes that must be loaded in a certain order, or before the independent classes...
require(REGISTRY_ENGINE_PATH . "classes/classes.php"); 


//Load Independent Classes
# These are classes that can be loaded in any order
# They do not make use of other independent classes

$scripts_dir = scandir(REGISTRY_ENGINE_PATH . "iclasses");

foreach($scripts_dir as $script)
{
	if($script == "." or $script == "..")
	{	
		//ignore these...
	}
	else
	{
		$extension = strrchr($script, ".");

		if($extension == ".php")
			require (REGISTRY_ENGINE_PATH . "/iclasses/" . $script);	
	}
}
?>
