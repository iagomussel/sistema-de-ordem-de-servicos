<?php

 header('Access-Control-Allow-Origin: *');
 include 'conectar.class.php';
 include 'query.class.php';
 include 'functions.php';

 function rule($dados)
 {
     Query::request($dados);
     if (!isset($dados['local'])) {
         Query::erro('tabela não localizada', true);
     }
     if (file_exists('models/'.$dados['local'].'.php')) {
         require 'models/'.$dados['local'].'.php';
     } else {
         Query::erro('Não Foi Possivel Encontrar o Arquivo');
         Query::erro('models/'.$dados['local'].'.php', true);
     }

     Query::json();
 }
 if (isset($_GET['local'])) {
     rule($_GET);
 }
