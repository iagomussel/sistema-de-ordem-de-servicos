<?php

Qr::inst("Cadastros/Tabelas/Tipos da Atendimento de OS","tipoAtendimentoOs")
	->Fields(
		Field::inst("id")->type("hidden"),
		Field::inst("descricao","Descrição"),
		Field::inst("permiteCobranca","Permite Cobrança?")
	)->layout();;
