<?php
//tem a função de impedir o acesso a usuarios não logados
if(!defined("RULE_CLASS")){
	require("rule.php");
}
sec_session_start();;
if(!User::login_check()){
	header("Location: login.php");
}

?>