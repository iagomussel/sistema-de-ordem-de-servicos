<?php
/**
 * Classe de conexão ao banco de dados usando PDO no padrão Singleton.
 * Modo de Usar:
 * require_once './Database.class.php';
 * $db = Database::conexao();
 * E agora use as funções do PDO (prepare, query, exec) em cima da variável $db.
 */
class Database
{
	
    # Variável que guarda a conexão PDO.
    protected static $db;
    # Private construct - garante que a classe só possa ser instanciada internamente.
	private function loadDatabaseIni(){
		return parse_ini_file("database.ini");
	}
    private function __construct()
    {
        # Informações sobre o banco de dados:
        $conf = self::loadDatabaseIni();
        # Informações sobre o sistema:
        try
        {
            # Atribui o objeto PDO à variável $db.
            self::$db = new PDO($conf["driver"].':host='.$conf["host"].'; dbname='.$conf["banco"], $conf["usuario"], $conf["senha"]);
            # Garante que o PDO lance exceções durante erros.
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Garante que os dados sejam armazenados com codificação UFT-8.
            self::$db->exec('SET NAMES utf8');
        }
        catch (PDOException $e)
        {
           
            die("Connection Error: " . $e->getMessage());
        }
    }
    # Método estático - acessível sem instanciação.
    public static function conexao()
    {
        # Garante uma única instância. Se não existe uma conexão, criamos uma nova.
        if (!self::$db)
        {
            new Database();
        }
        # Retorna a conexão.
        return self::$db;
    }
	public function auto_increment($a){
		$stmt = self::conexao()->prepare("SHOW TABLE STATUS LIKE '$a'");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result[0]["Auto_increment"];
	}
	public function insert($table,$data){
		if(array_key_exists(0, $data)){
			$sql = "INSERT INTO $table (".implode(array_keys($data[0]),",").") VALUES ";
			$nftcol=false;
			foreach($data as $c=>$a_one){
				if($nftcol){$sql.=",";};
				$sql.="(";				
				$nft=false;
				foreach($a_one as $d=>$a){
					if($nft){$sql.=",";};
					$sql.=":".$c."_".$d;
					$nft=true;
				}
				$sql.=")";
				$nftcol=true;
			}			
			$sql.=";";
			$stmt = self::conexao()->prepare($sql);
			foreach($data as $c=>$a_one){
				foreach($a_one as $d=>$a){
					$stmt->bindValue(":".$c."_".$d,$a);
				}
			}
		} else {
			$sql = "INSERT INTO $table (".implode(array_keys($data),",").") VALUES ( ";
			$nft=false;
			foreach($data as $c=>$a){
				if($nft){$sql.=",";};
				$sql.=":".$c;
				$nft=true;
			}
			$sql.=");";
			$stmt = self::conexao()->prepare($sql);
			foreach($data as $c=>$a){
				$stmt->bindValue(":".$c,$a);
			}
		}
		return $stmt->execute(); 	
		
	}
	public function update($table,$data,$where){
		
		$sql = "UPDATE $table SET ";
		//campos
		$nft=false;
		foreach($data as $c=>$a){
			if($nft){$sql.=",";};
			$sql.=" ".$c."=:".$c;
			$nft=true;
		}
		//condições
		$nft=false;
		$sql.=" WHERE ";
		foreach($where as $c=>$a){
			if($nft){$sql.=" AND ";};
			$sql.=" ".$c."=".$a;
			$nft=true;
		}
		$stmt = self::conexao()->prepare($sql);
		foreach($data as $c=>$a){
			$stmt->bindValue(":".$c,$a);
		}
		return $stmt->execute(); 	
	}
	public function remove($table,$where){
		$sql = "DELETE FROM $table WHERE ";
		$nft=false;
		foreach($where as $c=>$a){
			if($nft){$sql.=" AND ";};
			$sql.=" ".$c."=:".$c;
			$nft=true;
		} 
		$stmt =self::conexao()->prepare($sql);
		foreach($where as $c=>$a){
			$stmt->bindValue(":".$c,$a);
		}
		return $stmt->execute();
	}
	
	
}
$db = Database::conexao();
?>