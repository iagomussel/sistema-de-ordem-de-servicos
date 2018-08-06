<?php
header('Access-Control-Allow-Origin: *'); 
define("RULE_CLASS",true);
define("ABSPATH",dirname(__FILE__));
define("SECURE_LOGIN", FALSE); // para desenvolvimento 
define("ITENS_POR_PAGINA", 15); // para desenvolvimento 
define("TYPES_FORM_WITHOUT_LABEL",array("hidden")); 
 
define("NO_CACHE",time());
function __autoload($name) {
	$name = str_replace(["/","\\"],DIRECTORY_SEPARATOR,$name);
	
    require("classes".DIRECTORY_SEPARATOR.$name.".class.php");
};
include("functions.php");
$types = array('php' );
if ( $handle = opendir('models') ) {
    while ( $entry = readdir( $handle ) ) {
        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
        if( in_array( $ext, $types ) ) require_once(ABSPATH."\\models\\".$entry);
    }
    closedir($handle);
}  
?>
