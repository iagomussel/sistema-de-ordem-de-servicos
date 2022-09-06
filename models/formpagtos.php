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
					if(Database::insert($dados["local"],$dados_)){
						$dados_["id"] = Database::conexao()->lastInsertId();
						Query::data($dados_);
						Query::json();
						die();
					} else{
						Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
					}
				break;
				case "edit":
					if(!isset($dados["dados"])){
						Query::erro("é nescessario enviar os dados",true);
					}
					$dados_ = json_decode(base64_decode($dados["dados"]),true);
					if(!isset($dados_["id"])){
						Query::erro("erro id não encontrado",true);
					}
					$where = array("id"=>$dados_["id"]);
					if(Database::update($dados["local"],$dados_,$where)){
						Query::data($dados_);
						Query::json();
						die();
					} else{
						Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
					}
						
				break;
				case "get_all":
					$dados_ = json_decode(base64_decode($dados["dados"]),true);
					if(!isset($dados_["id"])){
							Query::erro("erro id não encontrado",true);
						};
					$stmt = $db->prepare("SELECT * FROM formpagtos where id=:id");
					$stmt->bindValue(":id",$dados_["id"]);
					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					Query::data($result);
					Query::json(true);	
					die();
				break;
				case "remove":
						$dados_ = json_decode(base64_decode($dados["dados"]),true);
						if(!isset($dados_["id"])){
							Query::erro("erro id não encontrado",true);
						}
						$stmt = $db->prepare("DELETE FROM formpagtos WHERE id = :id");
						$stmt->bindValue(":id",$dados_["id"]);
						if($stmt->execute()){
							Query::data($dados_);
							Query::json();
							die();
						} else {
							Query::erro("ERRO NO BANCO PDO, AO INCLUIR",true);
						}
				break;
				default:
					$sth = $db->prepare("select * from formpagtos");
					$sth->execute();
					$result = $sth->fetchAll(PDO::FETCH_ASSOC);
					Query::data($result);
					Query::json();
					die();
				break;
			}
		
?>
