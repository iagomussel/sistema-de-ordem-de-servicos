<?php

Qr::inst("Cadastros/Fornescedores")
	->Fields(
		Field::inst("id")->type("hidden"),
		Field::inst("nome"),
		Field::inst("Cnpj"),
		Field::inst("Ie"),
		Field::inst("im"),
		Field::inst("email"),
		Field::inst("endereco"),
		Field::inst("num"),
		Field::inst("bairro"),
		Field::inst("cidade"),
		Field::inst("cep"),
		Field::inst("telefone"),
		Field::inst("estado"),
		Field::inst("status")
	)->layout();
