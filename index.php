<?php
/*chama o loader de classe */
require("bootstrap.php");

/*faz backup*/
require("backup.php");

/*impede o acesso a pessoas não autorizadas*/
require("restrict.php");


require("app/view/index.php");
?>

