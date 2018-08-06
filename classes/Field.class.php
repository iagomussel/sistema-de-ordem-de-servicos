<?php
class Field{
	private $_validator = [];
	private $_getformaters = [];
	private $_setformaters = [];
	private $_dbField=NULL;
	private $_href=NULL;
	private $_title=NULL;
	private $_display=true;
	private $_type="text";
	private $_defaultValue="";
	
	public static function inst ()
	{
		$rc = new \ReflectionClass( get_called_class() );
		$args = func_get_args();
		return count( $args ) === 0 ?
			$rc->newInstance() :
			$rc->newInstanceArgs( $args );
	}
	function __construct( $dbField=null,$title=null)
		{
			if ( $dbField !== null ) {
				$this->dbField( $dbField );
				$href  = (strpos($dbField,'.'))?
								substr($dbField,strripos($dbField,'.')+1,strlen($dbField)):
								$dbField;
				$href = (strpos($href,' as '))?
								substr($href,strpos($href,' as ')+strlen(" as "),strlen($href)):
								$href;
				$this->href($href);
			}
			if ( $title !== null ) {
				$this->title( $title );
			} else {
				if ( $dbField !== null ) {
					$title = (strripos($dbField," as ")?
									(substr($dbField,strripos($dbField," as ")+strlen(' as '),strlen($dbField))):
									(strripos($dbField,'.')?substr($dbField,strripos($dbField,'.')+1,strlen($dbField)):$dbField));
					$this->title($title);
				}
			}
		}
	public function dbField ( $_=null )
	{
		if ( $_ === null ) {
			return $this->_dbField;
		}
		$this->_dbField = trim( $_ );
		return $this;
	}
	public function href ( $_=null )
	{
		if ( $_ === null ) {
			return $this->_href;
		}
		$this->_href = trim( $_ );
		return $this;
	}
	
	public function title ( $_=null )
	{
		if ( $_ === null ) {
			return $this->_title;
		}
		$this->_title = $_ ;
		return $this;
	}
	
	public function validator ( $_=null, $opts=null )
	{
		if ( $_ === null ) {
			return $this->_validator;
		}
		else {
			$this->_validator[] = array(
				"func" => $_,
				"opts" => $opts
			);
		}

		return $this;
	}
	
	public function validate ( $data )
	{
		// Three cases for the validator - closure, string or null
		if ( ! count( $this->_validator ) ) {
			return true;
		}

		
		for ( $i=0, $ien=count( $this->_validator ) ; $i<$ien ; $i++ ) {
			$validator = $this->_validator[$i];

			if ( is_string( $validator['func'] ) ) {
				// Don't require the Editor namespace if DataTables validator is given as a string
				$res = call_user_func( $validator['func'],  $data );
				
			}
			else {
				$func = $validator['func'];
				$res = $func($data,$validator['opts']);
			}

			// Check if there was a validation error and if so, return it
			if ( $res !== true ) {
				return $res;
			}
		}

		// Validation methods all run, must be valid
		return true;
	}
	
	/*FORMATA OS VALORES DOS CAMPOR ANTES DE INSERIR/ EDITAR OU APÓS CONSULTAR*/
	public function getFormater($func=null){
		return $this;
	}
	public function setFormater($func=null){
		return $this;
	}
	public function formate($data,$ac="get"){
		$data_formated = $data;
		$arr = ($ac == "get")?
					$this->_getformaters:
					($ac == "set")?
						$this->_setformaters:
						array();
		foreach($arr as $a){
			$data_formated = $a($data_formated);
		}
		return $data_formated;
	}
	public function display($_=null){
		if($_===null){
			return $this->_display;
		}
		$this->_display = $_;
		return $this;
	}
	public function type($_=null){
		if($_===null){
			return $this->_type;
		}
		$this->_type = $_;
		return $this;
	}
	public function defaultValue($_=null){
		if($_===null){
			return $this->_defaultValue;
		}
		$this->_defaultValue = $_;
		return $this;
	}
}