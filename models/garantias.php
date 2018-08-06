<?php

Qr::inst("Cadastros/Garantias")
	->Fields(
		Field::inst("id")->type("hidden"),
		Field::inst("descricao")
	)->layout();;
