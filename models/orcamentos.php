<?php
if(!isset($db)){
	$db = Database::conexao();
}

if(!isset($dados["acao"])) $dados["acao"] = "view";
			switch($dados["acao"]){
				case "add":
					
					if(!isset($dados["dados"])){
						Query::erro('é nescessario enviar os dados',true);
					}
					$dados_ = json_decode(base64_decode($dados["dados"]),true);
					$os = $dados_;
					$tarefas = $dados_["servicos"];
					unset($os["servicos"]);
					//calcular valor total
					$os["valor"] = 0;
					foreach($tarefas as $c=>$a){
							$os["valor"]+=$a["quantidade"]*$a["valorunit"];
						}
					//ajustar a data
					$data_os = explode("/",$os["data"]);
					if(count($data_os) == 3){
						$os["data"]=date("Y-m-d",mktime(0,0,0,$data_os[1],$data_os[0],$data_os[2]));
					} else {
						$os["data"]=date("Y-m-d");
					}
					//define como orcamento
					$os["status"] = 1;
					if(Database::insert("os",$os)){
						$os["id"] = Database::conexao()->lastInsertId();
						foreach($tarefas as $c=>$a){
							$tarefas[$c]["idos"] = $os['id'];
						}
						if(Database::insert("osxservicos",$tarefas)){
							$os["servicos"] = $tarefas;
						} else {
							Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
						}
						$os["data"] = date("d/m/Y",strtotime($os["data"]));
						Query::data($os);
						Query::json();
						die();
					} else{
						Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
					}
				break;
				case "edit":
					if(!isset($dados["dados"])){
						Query::erro('é nescessario enviar os dados',true);
					}
					$dados_ = json_decode(base64_decode($dados["dados"]),true);
					$os = $dados_;
					$tarefas = $dados_["servicos"];
					unset($os["servicos"]);
					
					//calcular valor total
					$os["valor"] = 0;
					foreach($tarefas as $c=>$a){
							$os["valor"]+=$a["quantidade"]*$a["valorunit"];
						}
					
					//ajustar a data
					$data_os = explode("/",$os["data"]);
					if(count($data_os) == 3){
						$os["data"]=date("Y-m-d",mktime(0,0,0,$data_os[1],$data_os[0],$data_os[2]));
					} else {
						$os["data"]=date("Y-m-d");
					}
					if(Database::update("os",$os,array("id"=>$os["id"]))){
						if(!Database::remove("osxservicos",array("idos"=>$os["id"]))){
							Query::error("Não foi possivel deletar as entradas na relação, OS x Servicos",true);
						};
						
						foreach($tarefas as $c=>$a){
							$tarefas[$c]["idos"] = $os["id"];
						}
						
						if(Database::insert("osxservicos",$tarefas)){
							$os["servicos"] = $tarefas;
						} else {
							Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
						}
						$os["data"] = date("d/m/Y",strtotime($os["data"]));
						Query::data($os);
						Query::json();
						die();
					} else{
						Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
					}
				break;
				case 'autorizar':
				if(!isset($dados["dados"])){
						Query::erro('é nescessario enviar os dados',true);
					}
					$dados_ = json_decode(base64_decode($dados["dados"]),true);
					if(Database::update("os",array("status"=>0),$dados_)){
						Query::data($dados_);
						Query::json();
						die();
					} else {
						Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
					}
					
				break;
				case "get_all":
					$dados_ = json_decode(base64_decode($dados["dados"]),true);
					if(!isset($dados_["id"])){
							Query::erro("erro id não encontrado",true);
						};
					$stmt = $db->prepare("SELECT * FROM os where id=:id");
					$stmt->bindValue(":id",$dados_["id"]);
					$stmt->execute();
					$os = $stmt->fetchAll(PDO::FETCH_ASSOC);
					//servicos
						$stmt = $db->prepare("SELECT * FROM osxservicos where idos=:id");
						$stmt->bindValue(":id",$dados_["id"]);
						$stmt->execute();
						$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$os[0]["servicos"] = $tarefas;
					$os[0]["data"]=date("d/m/Y",strtotime($os[0]["data"]));
					Query::data($os);
					Query::json(true);	
					die();
				break;
				case "remove":
						$dados_ = json_decode(base64_decode($dados["dados"]),true);
						if(!isset($dados_["id"])){
							Query::erro("erro id não encontrado",true);
						}
						if(!Database::remove("osxservicos",array("idos"=>$dados_["id"]))){
							Query::error("Não foi possivel deletar as entradas na relação, OS x Servicos",true);
						};
						if(!Database::remove("os",array("id"=>$dados_["id"]))){
							Query::error("Não foi possivel deletar as entradas na OS",true);
						};
						Query::data($dados_);
						Query::json();
						die();
				break;
				default:
					$sth = $db->prepare("select 
						os.id,os.valor,DATE_FORMAT( os.data, '%d\/%m\/%Y' ) as data,
						clientes.nome as cliente,
						veiculos.placa as veiculo,
						funcionarios.nome as funcionario,
						formpagtos.descricao as formpagto,
						condpagtos.descricao as condpagto,
						garantias.descricao as garantia
						from os 
							LEFT join clientes on clientes.id = os.cliente
							LEFT JOIN veiculos on veiculos.id = os.veiculo
							LEFT join funcionarios on funcionarios.id = os.funcionario
							LEFT join formpagtos on formpagtos.id = os.formpagto
							LEFT join condpagtos on condpagtos.id = os.formpagto
							LEFT join garantias on garantias.id = os.garantia WHERE os.status = 1");
					$sth->execute();
					$result = $sth->fetchAll(PDO::FETCH_ASSOC);
					Query::data($result);
					Query::json();
					die();
				break;
			}
		
?>

			}
		
?>

