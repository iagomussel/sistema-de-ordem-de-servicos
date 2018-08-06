<?php

$qr = Qr::inst("Cadastros/Tabelas/Clientes/Veiculos")
	->Fields(
		Field::inst("veiculos.id")->type("hidden"),
		Field::inst("veiculos.placa","Placa"),
		Field::inst("clientes.nome as cliente","Proprietario"),
		Field::inst("veiculos.fabricante","Fabricante"),
		Field::inst("veiculos.modelo","Modelo")
	)->leftJoin("clientes","veiculos.cliente","=","clientes.id")
	->layout();