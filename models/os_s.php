<?php

function formate_os_databp($data){
	switch($data["acao"]){
				case "add":
				case "edit":
					$sdata = $data;
					
					//calcular valor total
					$sdata["dados"]["valor"] = 0;
					if(!isset($sdata["dados"]["servico.quantidade"])) exit();
					if(!is_array($sdata["dados"]["servico.quantidade"])){
						$s = array();
						array_push($s,$sdata["dados"]["servico.quantidade"]);
						$sdata["dados"]["servico.quantidade"] = $s;
					}
					foreach($sdata["dados"]["servico.quantidade"]as $ch=>$val){
							if(!isset($sdata["servicos"])){
								$sdata["servicos"]= array();
							}
							array_push($sdata["servicos"],array(
								"quantidade"=>$sdata["dados"]["servico.quantidade"][$ch],
								"servico"=>$sdata["dados"]["servico.servico"][$ch],
								"valorunit"=>$sdata["dados"]["servico.valorunit"][$ch]
							));
					}
					
					
					//ajustar a data
					$data_os = explode("/",$data["dados"]["data"]);
					if(count($data_os) == 3){
						$sdata["data"]=date("Y-m-d",mktime(0,0,0,$data_os[1],$data_os[0],$data_os[2]));
					} else {
						$sdata["data"]=date("Y-m-d");
					}
					
					foreach($sdata["dados"]	as $ch=>$val){
						if(strpos($ch,".")){
							unset($sdata["dados"][$ch]);
						}
					}
					//var_dump($sdata);
					
					
					return $sdata;
				break;
				default:
					return $data;
				break;
			}
}
function formate_os_dataap($data,$request){
					
	$conservice = Qr::inst("osxservicos");
	switch($request["request"]["acao"]){
				case "add":
					$data["servicos"] = array(); 
					foreach($request["request"]["servicos"] as $service){
						$service["id"] = $data["id"];
						array_push($data["servicos"],$service);
						$conservice->add($service);
					}
					return $data;
				break;
				
				case "edit":
				$data["servicos"] = array(); 
					// deletar serviços
					$conservice->remove(array("id"=>$data["id"]));
					//add serviços
					foreach($request["request"]["servicos"] as $service){
						$service["id"] = $data["id"];
						array_push($data["servicos"],$service);
						$conservice->add($service);
					}
					return $data;
				break;
				case "get":
					$data["servicos"] = $conservice->search(array("page"=>0,"data"=>array("id"=>$data["id"])));
					var_dump($data);
					return $data;
				break;
				default:
					return $data;
				break;
			}
}


Qr::inst("Serviços/Ordem de Servicos","os")
	->fields(
		field::inst("os.id","#")->type("hidden"),
		field::inst("os.valor","Valor"),
		field::inst("DATE_FORMAT( os.data, '%d\/%m\/%Y' ) as data","Data"),
		field::inst("clientes.nome as cliente","Cliente"),
		field::inst("veiculos.placa as veiculo","Equipamento"),
		field::inst("funcionarios.nome as funcionario","Funcionario"),
		field::inst("formpagtos.descricao as formpagto","Forma de pagamento"),
		field::inst("condpagtos.descricao as condpagto","Condição de Pagamento"),
		field::inst("garantias.descricao as garantia","Garantia")
	)
	->leftJoin("clientes","clientes.id","=","os.cliente")
	->leftJoin("veiculos","veiculos.id","=","os.veiculo")
	->leftJoin("funcionarios","funcionarios.id","=","os.funcionario")
	->leftJoin("formpagtos","formpagtos.id","=","os.formpagto")
	->leftJoin("condpagtos","condpagtos.id","=","os.condpagto")
	->leftJoin("garantias","garantias.id","=","os.garantia")
	->beforeProcess("formate_os_databp")
	->afterProcess("formate_os_dataap")
	->layout();

	
	
	
	
	
