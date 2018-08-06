<?php
qr::inst("Cadastros/Parcelamentos.","condpagtos")
	->Fields(
		Field::inst("id")->type("hidden"),
		Field::inst("descricao")
	)
	->layout();;
