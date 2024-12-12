<?php

    date_default_timezone_set('America/Sao_Paulo');
    $back = 'backup/';
    $filenome = date('Ymd').'.sql';
    $conf = parse_ini_file('database.ini');
    $senha = '';

    if (strlen($conf['senha']) > 0) {
        $senha = ' -p '.$conf['senha'];
    }
    echo 'criando backup em:'.$back.$filenome;
    echo 'mysqldump -h '.$conf['host'].' -u '.$conf['usuario'].$senha.' --lock-tables '.$conf['banco'].' > '.$back.$filenome;
    system('mysqldump -h '.$conf['host'].' -u '.$conf['usuario'].$senha.' --lock-tables '.$conf['banco'].' > '.$back.$filenome);
