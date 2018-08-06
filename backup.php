<?php
	date_default_timezone_set("America/Sao_Paulo");
	$filename="../backup/".date("Ymd").".sql";
	if(!file_exists($filename)){
		$conf = parse_ini_file("database.ini");
		$senha = "";	
		if(strlen($conf['senha'])>0) $senha = " -p ".$conf['senha'];
			
		include_once(dirname(__FILE__) . '/mysqldump-php-master/src/Ifsnop/Mysqldump/Mysqldump.php');
		$dump = new Mysqldump($conf["driver"].':host='.$conf["host"].';dbname='.$conf["banco"],$conf['usuario'] , $senha);
		$dump->start($filename);
	}
	

	?>
