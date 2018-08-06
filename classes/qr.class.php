<?php

class Qr{
	private $_tabela=NULL;
	private $_caminho=NULL;
	private $_href=NULL;
	private $_title=NULL;
	private $_fields=[];
	private $_joins=[];
	private $_bProcess=[];
	private $_aProcess=[];
	private $_where=NULL;
	private $_limit=[0,ITENS_POR_PAGINA];
	
	protected static $tabelas=[]; // armazena todas as instancias de qr para evitar duplicidade
	
	public function __construct($caminho,$table=NULL){
		if(empty($caminho))return false;
		$this->_caminho = $caminho;
		if($table===null){
			$table=(strpos($caminho,"/"))?substr($caminho,strripos($caminho,'/')+1,strlen($caminho)):$caminho;
		}
		$this->_tabela= sanitizeString($table);
		$this->_title=(strripos($caminho,'/'))?
						substr($caminho,strripos($caminho,'/')+1,strlen($caminho))
						:$caminho;;
		$this->_href = sanitizeString($caminho);
		self::$tabelas[$this->_tabela] = $this;
	}
	public function inst($caminho,$table=NULL){
		if(empty($caminho))return false;
		if($table===null){
			$table=(strpos($caminho,"/"))?substr($caminho,strripos($caminho,'/')+1,strlen($caminho)):$caminho;
		}
		$table= sanitizeString($table);
		if(isset(self::$tabelas[$table])){
			return self::$tabelas[$table];
		} else {
			return new Qr($caminho,$table);
		}	
	}
	public function processa($_dados){
		$dados = $_dados;
		if(isset($dados["dados"])){
			$dados["dados"] = json_decode(base64_decode($dados["dados"]),true);
		}
		$dados = $this->beforeProcess_exec($dados);
		if(isset($dados["local"])&&isset($dados["acao"])){
			Query::request($dados);
			switch($dados["acao"]){
				case "add":
					$dat = $this->add($dados["dados"]);
					if($dat){
						Query::data($dat);
					}
					return $this;
				break;
				case "edit":
				
					$dat = $this->edit($dados["dados"]);
					if($dat){
						Query::data($dat);
					}
					return $this;
				break;
				case "remove":
					$dat = $this->remove($dados["dados"]);
					if($dat){
						Query::data($dat);
					}
					return $this;break;
				case 'get':
					$dat = $this->get($dados["dados"]);
					if($dat){
						Query::data($dat);
					}
					return $this;
				break;
				case 'consulta':
				case 'search':
				
					$dat = $this->search($dados);
					if($dat){
						Query::data($dat);
					}
					return $this;
				break;
				default:	
					Query::erro("Açao desconhecida",true);
				break;
			}
		}
	}
	public function add($dados){

		$dados_processados = [];
		
		foreach($this->fields() as $field){
			if($field->validate(
				isset($dados[$field->href()])?
				$dados[$field->href()]:
				null
				)){
				$fd = $field->formate(
				isset($dados[$field->href()])?
				$dados[$field->href()]:
				null,"add");
				if($fd!==null){
					$dados_processados[$field->href()] = $fd;
					//echo $field->href()."  |  - esse tem _\n ";
				} else{
					//echo $field->href()." \n  ";
				}
			}
			
		}
		$db =  database::inst();
		if($db->insert($this->table(),$dados_processados)){
			$dados_processados["id"] = $db->lastInsertId();
			return $this->afterProcess_exec($dados_processados);
		}
		Query::error("erro ao incluir");
		return false;
	}
	public function edit($dados){
	
		if(!isset($dados["id"])){
			Query::erro('Registro não atualizado',true);
		}
		$dados_processados = [];
		foreach($this->fields() as $field){
			if($field->validate(
				isset($dados[$field->href()])?
				$dados[$field->href()]:
				null
				)){
					$fd = $field->formate(
				isset($dados[$field->href()])?
				$dados[$field->href()]:
				null,"edit");
				if($fd!==null){
					$dados_processados[$field->href()] = $fd;
					//echo $field->href()."  |  - esse tem _\n ";
				} else{
					//echo $field->href()." \n  ";
				}
			}
		}
		$where = ["id"=>$dados_processados["id"]];
		unset($dados_processados["id"]);
		$db =  database::inst();
		if($db->update($this->table(),$dados_processados,$where)){
			return $this->afterProcess_exec($dados_processados);
		} 
		Query::erro("erro ao edita regstros",true);
		
		return false;
	}
	public function remove($dados){
		if(empty($dados)){
			Query::erro("erro registro não encontrado",true);
		}
		if(Database::remove($this->table(),$dados)){
			return $dados;		
		} else {
			Query::erro("não foi possivel excluir o registro",true);
		}
		return false;
	}
	public function get($dados){
			$this->_where = new Where();
			for($a=0;$a<count($this->_fields);$a++){
				$dbField = $this->_fields[$a]->dbField();
				$dbField = strpos($dbField," as ")?substr($dbField,0,strpos($dbField," as ")):$dbField;
				$dbField = trim($dbField);
				$fil = strpos($dbField,".")?
				substr($dbField,strripos($dbField,".")+1,strlen($dbField)):
				$dbField;
				if(isset($dados[$fil]))
					$this->_where->and(
								$dbField,
								$dados[$fil]
								,"=");
			}
		
		$db = database::inst();
		if($db->select($this->_tabela,$this->_where,null,null,$this->_limit,["id"],"ASC",true)){
			return $db->result();	
		}
		Query::erro("erro na consulta");
		return false;
	}
	public function consulta($dados=array()){
		$pagina = 1;
		if(isset($dados["page"])&&$dados["page"]>0){
			$pagina = $dados["page"];
			$this->_limit = [($pagina-1)* ITENS_POR_PAGINA, ITENS_POR_PAGINA]	;
		} else {
			$this->_limit = null;
		}
		$db = database::inst();
		$db->select($this->_tabela,NULL,$this->_fields,$this->_joins,$this->_limit);
		Query::paginate(($pagina>0)?$pagina:1,(ceil($db->count()/ITENS_POR_PAGINA)>0)?ceil($db->count()/ITENS_POR_PAGINA):1);
		return ($db->result());			

	}
	public function search($dados=array()){
		$pagina = 1;
		if(isset($dados["page"])&&$dados["page"]>0){
			$pagina = $dados["page"];
			$this->_limit = [($pagina-1)* ITENS_POR_PAGINA, ITENS_POR_PAGINA]	;
		} else {
			$this->_limit = null;
		}
		if((!isset($dados["term"])||(empty($dados["term"])))&&(!isset($dados["data"])||empty($dados["dados"])))
		{
			return $this->consulta($dados);
		}
		if(isset($dados["term"])&&(!empty($dados["term"]))){
			$this->_where = new Where();
			for($a=0;$a<count($this->_fields);$a++){
				$dbField = $this->_fields[$a]->dbField();
				$dbField = strpos($dbField," as ")?substr($dbField,0,strpos($dbField," as ")):$dbField;
				$dbField = trim($dbField);
				$this->_where->or("".$dbField."","%".strtoupper($dados["term"])."%","LIKE");
			}
		}
		if(isset($dados["data"])){
			for($a=0;$a<count($this->_fields);$a++){
				$dbField = $this->_fields[$a]->dbField();
				$dbField = strpos($dbField," as ")?substr($dbField,0,strpos($dbField," as ")):$dbField;
				$dbField = trim($dbField);
				$fil = strpos($dbField,".")?
				substr($dbField,strripos($dbField,".")+1,strlen($dbField)):
				$dbField;
				if(isset($dados["data"][$fil]))
					$this->_where->and(
								$dbField,
								$dados["data"][$fil]
								,"=");
			}
		}
		
		$db =  database::inst();
		;
		Query::data(
			$db->select($this->_tabela,$this->_where,$this->_fields,$this->_joins,$this->_limit)->result()
		);
		Query::paginate(($pagina>0)?$pagina:1,(ceil($db->count()/ITENS_POR_PAGINA)>0)?ceil($db->count()/ITENS_POR_PAGINA):1);
		return $this;
	}
	public function json(){
		Query::json();
		return $this;
	}
	public function fields ( $_=null )
	{
		if ( $_ === null  ) {
			return $this->_fields;
		}
			if(!is_array($_))$_ = func_get_args();
			for($a=0;$a<count($_);$a++)
			{
				$this->_fields[]=$_[$a];
			}
		
		return $this;
	}
	public function layout(){
		if(!isset($this)){
			return false;
		}
		Layout::addEntry($this);
		return $this;
	}
	public function Table($_=null){
		if($_===null)
			return $this->_tabela;
		$this->_tabela = $_;
		return $this;
	}
	public function Caminho($_=null){
		if($_===null)
			return $this->_caminho;
		$this->_caminho = $_;
		return $this;	
	}
		
	public function Href($_=null){
		if($_===null)
			return $this->_href;
		$this->_href = $_;
		return $this;
	}
	public function Title($_=null){
		if($_===null)
			return $this->_title;
		$this->_title = $_;
		return $this;
	}
	
	public function leftJoin($table,$field1,$oper="=",$field2){
		$this->_joins[]=" LEFT JOIN $table ON $field1 $oper $field2 ";
		return $this;
	}
	public function beforeProcess ( $_=null, $opts=null )
	{
		if ( $_ === null ) {
			return $this->_bProcess;
		}
		else {
			$this->_bProcess[] = array(
				"func" => $_,
				"opts" => $opts
			);
		}
		return $this;
	}
	public function beforeProcess_exec($data){
		if ( ! count( $this->_bProcess ) ) {
			return $data;
		}

		
		for ( $i=0, $ien=count( $this->_bProcess ) ; $i<$ien ; $i++ ) {
			$proc = $this->_bProcess[$i];

			if ( is_string( $proc['func'] ) ) {
				// Don't require the Editor namespace if DataTables validator is given as a string
				$data = call_user_func( $proc['func'],  $data,$proc["opts"] );
				
			}
			else {
				$func = $proc['func'];
				$data = $func($data,$proc['opts']);
			}

			// Check if there was a validation error and if so, return it
			
		}
		return $data;
	}
	public function afterProcess ( $_=null, $opts=null )
	{
		if ( $_ === null ) {
			return $this->_aProcess;
		}
		else {
			$this->_aProcess[] = array(
				"func" => $_,
				"opts" => $opts
			);
		}
		return $this;
	}
	public function afterProcess_exec($data){
		if ( ! count( $this->_aProcess ) ) {
			return $data;
		}
		for ( $i=0, $ien=count( $this->_aProcess ) ; $i<$ien ; $i++ ) {
			$proc = $this->_aProcess[$i];

			if ( is_string( $proc['func'] ) ) {
				// Don't require the Editor namespace if DataTables validator is given as a string
				$data = call_user_func( $proc['func'],  $data,Query::get_return() );
				
			}
			else {
				$func = $proc['func'];
				$data = $func($data,Query::get_return());
			}
			// Check if there was a validation error and if so, return it
		}
		return $data;
	}
	
}
