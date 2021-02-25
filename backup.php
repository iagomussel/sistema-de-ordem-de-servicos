<?php
date_default_timezone_set("America/Sao_Paulo");
	$back = "d:/";
	$filenome="BACKUP_".date("d-m-Y__H-i-s").".sql";
	$conf = parse_ini_file("database.ini");
	$senha = "";
	if(strlen($conf['senha'])>0) $senha = " -p ".$conf['senha'];
	//echo "mysqldump -h ".$conf["host"]." -u ".$conf['usuario'].$senha." --lock-tables ".$conf['banco']." > ".$back.$filenome;
    system("mysqldump -h ".$conf["host"]." -u ".$conf['usuario'].$senha." --lock-tables ".$conf['banco']." > ".$back.$filenome);

	?>
