<?php
qr::inst("Cadastros/Formas de Pagto","formpagtos")
	->Fields(
		Field::inst("id","#")->type("hidden"),
		Field::inst("descricao")
	)
	->layout();;

	