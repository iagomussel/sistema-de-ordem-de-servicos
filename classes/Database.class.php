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
    protected static $instance;
	protected $_lastResult;
	protected $_countLastResult;
	private $_sql;
    # Private construct - garante que a classe só possa ser instanciada internamente.
	private function loadDatabaseIni(){
		return parse_ini_file("database.ini");
	}
    private function __construct()
    {
		if(isset(self::$isntance)){
			return;
		}
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
		self::$instance == $this;
    }
	public function sql(){
		return $this->_sql;
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
			$this->_sql = "INSERT INTO $table (".implode(array_keys($data[0]),",").") VALUES ";
			$nftcol=false;
			foreach($data as $c=>$a_one){
				if($nftcol){$this->_sql.=",";};
				$this->_sql.="(";				
				$nft=false;
				foreach($a_one as $d=>$a){
					if($nft){$this->_sql.=",";};
					$this->_sql.=":".$c."_".$d;
					$nft=true;
				}
				$this->_sql.=")";
				$nftcol=true;
			}			
			$this->_sql.=";";
			$stmt = self::conexao()->prepare($this->_sql);
			foreach($data as $c=>$a_one){
				foreach($a_one as $d=>$a){
					$stmt->bindValue(":".$c."_".$d,$a);
				}
			}
		} else {
			$this->_sql = "INSERT INTO $table (".implode(array_keys($data),",").") VALUES ( ";
			$nft=false;
			foreach($data as $c=>$a){
				if($nft){$this->_sql.=",";};
				$this->_sql.=":".$c;
				$nft=true;
			}
			$this->_sql.=");";
			$stmt = self::conexao()->prepare($sql);
			foreach($data as $c=>$a){
				$stmt->bindValue(":".$c,$a);
			}
		}
		$this->result($stmt->execute());
		return $this;
	}
	public function update($table,$data,$where){
		
		$this->_sql = "UPDATE $table SET ";
		//campos
		$nft=false;
		foreach($data as $c=>$a){
			if($nft){$this->_sql.=",";};
			$this->_sql.=" ".$c."=:".$c;
			$nft=true;
		}
		//condições
		$nft=false;
		$this->_sql.=" WHERE ";
		foreach($where as $c=>$a){
			if($nft){$this->_sql.=" AND ";};
			$this->_sql.=" ".$c."=".$a;
			$nft=true;
		}
		$stmt = self::conexao()->prepare($this->_sql);
		foreach($data as $c=>$a){
			$stmt->bindValue(":".$c,$a);
		}
		$this->result($stmt->execute());
		return $this;
	}
	public function remove($table,$where){
		$this->_sql = "DELETE FROM $table WHERE ";
		$nft=false;
		foreach($where as $c=>$a){
			if($nft){$this->_sql.=" AND ";};
			$this->_sql.=" ".$c."=:".$c;
			$nft=true;
		} 
		$stmt =self::conexao()->prepare($sql);
		foreach($where as $c=>$a){
			$stmt->bindValue(":".$c,$a);
		}
		$this->result($stmt->execute());
		return $this;
	}
	public function query($sql){
		$stmt =self::conexao()->prepare($sql);
		$stmt->execute();
		$this->result($stmt->fetchAll(PDO::FETCH_ASSOC));
		$stmt = self::conexao()->prepare("SELECT FOUND_ROWS() as total;");
		$stmt->execute();
		$ss = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!isset($ss["total"])) var_dump($ss);
		$this->_countLastResult = $ss["total"];
		return $this;
	}
	public function select($table,$where=NULL,$fields=NULL,$joins=NULL,$limit=[10],$order=array("id"),$desc="DESC",$displayall=false){
		$this->_sql = "SELECT SQL_CALC_FOUND_ROWS ";
		//inclui os campos que serão carregados
		if($fields === NULL){
			$this->_sql.=" * ";
		} else {
			for($a=0; $a<count($fields);$a++){
				
				if($fields[$a]->display()||$displayall){
				if($a>0)$this->_sql.=", ";
				$this->_sql.=$fields[$a]->dbField();
				}
			}
		}
		//designa a tabela
		$this->_sql.=" from ".$table;
		
		//inclui os joins  (string)
		
		if($joins !== NULL){
			for($a=0; $a<count($joins);$a++){
				$this->_sql.=$joins[$a]." ";
			}
		}
		if($where&&!empty($where->sql())){
			$this->_sql.=" where ".$where->sql()." ";
		} 
		
		$this->_sql.=" ORDER BY ".implode(', ',$order)." ".$desc." ";
		if(count($limit)===2){
			$this->_sql.= " LIMIT ".$limit[0].",".$limit[1]."";
		} elseif(count($limit)===1){
			$this->_sql.= " LIMIT ".$limit[0]."";
		}
		$this->_sql.=";";
		//echo $sql;
		return $this->query($this->_sql);
	}
	
	public function inst(){
		if(isset(self::$instance))
			return self::$instance;
		return new Database();
	}
	
	public function result($_=null){
		if($_===null)
			return $this->_lastResult;
		$this->_lastResult = $_;
		return $this;
	}
	public function count(){
		return $this->_countLastResult;
	}
	public function lastInsertId(){
		return $this->conexao()->lastInsertId();
	}
	
	 private function ln($text = '') {
        $this->_sql = $this->_sql . $text . "\n";
    }

	public function dump($filename){
		$this->ln("SET FOREIGN_KEY_CHECKS=0;\n");

        $tables = $this->db->query('SHOW TABLES')->fetchAll(PDO::FETCH_BOTH);

        foreach ($tables as $table) {
            $table = $table[0];
            $this->ln('DROP TABLE IF EXISTS `'.$table.'`;');

            $schemas = $this->db->query("SHOW CREATE TABLE `{$table}`")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($schemas as $schema) {
                $schema = $schema['Create Table'];
                $schema = preg_replace('/AUTO_INCREMENT=([0-9]+)(\s{0,1})/', '', $schema);
                $this->ln($schema.";\n\n");
            }
        }
		
        file_put_contents($file, $this->_sql);
	}
}
?>