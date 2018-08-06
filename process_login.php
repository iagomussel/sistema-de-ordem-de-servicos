<?php
if(!defined("RULE_CLASS")){
	include_once 'bootstrap.php';
}
 
sec_session_start(); // Nossa segurança personalizada para iniciar uma sessão php.
 
if (isset($_POST['username'], $_POST['p'])) {
    $username = $_POST['username'];
    $password = $_POST['p']; // The hashed password.
    if (User::login($username, $password) == true) {
        // Login com sucesso 
        header('Location: index.php');
    } else {
        // Falha de login 
        header('Location: login.php?error=1');
    }
} else {
    // As variáveis POST corretas não foram enviadas para esta página. 
    echo 'Invalid Request' ;
}