<?php
	qr::inst("Cadastros/Clientes")
	->Fields(
		Field::inst("clientes.id","#")->type("hidden"),
		Field::inst("clientes.cnpj","CNPJ"),
		
		Field::inst("clientes.nome","Nome"),
		Field::inst("clientes.ie")
					->display(false),
		Field::inst("clientes.im")
					->display(false),
		Field::inst("clientes.email")
					->display(false),
		Field::inst("clientes.endereco")
					->display(false),
		Field::inst("clientes.num")
					->display(false),
		Field::inst("clientes.bairro")
					->display(false),
		Field::inst("cidade.nome as cidade")
					->display(false),
		Field::inst("clientes.cep")
					->display(false),
		Field::inst("clientes.telefone")
					->display(false),
		Field::inst("clientes.complemento")
					->display(false),
					
		Field::inst("clientes.suframa")
					->display(false),
		Field::inst("estado.uf as uf","UF"),
		Field::inst("clientes.status")
					->display(false)
	)
	->leftJoin("cidade","clientes.cidade","=","cidade.id")
	->leftJoin("estado","cidade.idEstado","=","estado.id")
	->layout();
