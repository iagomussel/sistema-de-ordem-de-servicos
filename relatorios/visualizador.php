
<?php
if(file_exists("relatorios/visualizador/".$dados["local"].".php")){
	require("relatorios/visualizador/".$dados["local"].".php");
} else {
	echo ("relatorios/visualizador/".$dados["local"].".php");
	die("arquivo não encontrado");
}
?>
