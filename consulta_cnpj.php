<?php
if(!defined("RULE_CLASS")){
	require("bootstrap.php");
}
$url = "https://www.receitaws.com.br/v1/cnpj/".$_GET["cnpj"];
if(!validar_cnpj($_GET["cnpj"])){
		echo '{"status":"ERROR","message":"CNPJ invalido"}';
	die();
}
$res = curl_init();
if(!$res)
{
	echo '{"status":"ERROR","message":"Erro interno no CURL"}';
	die();
}
curl_setopt($res,CURLOPT_URL,$url);
curl_setopt($res,CURLOPT_RETURNTRANSFER,true);

$resposta = json_decode(curl_exec($res),true);
$response_code = curl_getinfo($res, CURLINFO_HTTP_CODE);
if($response_code == '200'){
	if(isset($resposta["status"])&&($resposta["status"]=="ERROR")){
		echo json_encode($resposta,JSON_PRETTY_PRINT);
		die();
	}
	
	//conectando ao db para estado / cidade
	if(!isset($db)){
		$db = Database::conexao();
	}
	$sth = $db->prepare("select Id from estado WHERE Uf =:uf");
	$sth->bindValue(":uf",$resposta["uf"]);
	$sth->execute();
	$uf = $sth->fetch(PDO::FETCH_ASSOC);
	$sth = $db->prepare("select Id from cidade WHERE idEstado =:uf and Nome =:nome");
	$sth->bindValue(":uf",$uf["Id"]);
	$sth->bindValue(":nome",$resposta["municipio"]);
	$sth->execute();
	$cidade = $sth->fetch(PDO::FETCH_ASSOC);
	$resposta["uf"] = $uf["Id"];
	$resposta["municipioNome"] = $resposta["municipio"];
	$resposta["municipio"] = $cidade["Id"];
	echo json_encode($resposta,JSON_PRETTY_PRINT);
	
} else {
	echo '{"ERROR":"Não encontrado"}';
	die();
}


?>