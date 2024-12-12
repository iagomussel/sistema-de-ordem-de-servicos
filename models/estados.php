<?php

if (!isset($db)) {
    $db = Database::conexao();
}
$sth = $db->prepare('select Id,Nome,Uf from estado');
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
Query::data($result);
Query::json();
exit;
