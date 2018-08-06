<?php

Qr::inst("Cadastros/Funcionarios")
	->Fields(
		Field::inst("id")->type("hidden"),
		Field::inst("nome")
	)->layout();;
