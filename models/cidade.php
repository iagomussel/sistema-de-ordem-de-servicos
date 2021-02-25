<?php
if(!isset($db)){
	$db = Database::conexao();
}
	$sth = $db->prepare("select Id,IdEstado,Nome from cidade");
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	Query::data($result);
	Query::json();
	die();
?>
