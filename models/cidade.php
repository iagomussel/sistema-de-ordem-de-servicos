<?php
	qr::inst("Cadastros/Tabelas/Clientes/Cidade")
	->Fields(
		Field::inst("cidade.id","#")->type("hidden"),
		Field::inst("cidade.Nome"),
		Field::inst("estado.uf as UF")->type("select")
	)->leftJoin("estado","estado.id","=","cidade.idEstado")
	->layout();;

