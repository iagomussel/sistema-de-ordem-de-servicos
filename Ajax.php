<?php
if(!defined("RULE_CLASS")){
require("bootstrap.php");
}
require("restrict.php");
if(isset($_REQUEST["local"])&&isset($_REQUEST["acao"])){
	$qr = Qr::inst(strtolower($_REQUEST["local"]))	;
	if($qr){
		$qr->processa($_REQUEST)
		->json();
	} else {
		query::erro("a tabela nao foi encontrada",true);
	}
	
}