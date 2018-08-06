<?php
	qr::inst("Cadastros/Tabelas/Usuarios","usuarios")
	->Fields(
		Field::inst("id","#")->type("hidden"),
		Field::inst("username","Nome de Usuário"),
		Field::inst("fullname","Nome completo"),
		Field::inst("email","Email"),
		Field::inst("password","password")->display(false)->type("password")
			->getFormater()
			->setFormater()
		
	)->layout();;
