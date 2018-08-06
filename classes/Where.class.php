<?php

class Where{
	
	private $_sql=null;
	public function __construct(){
		
	}
	public function or($field,$val=true,$opera='='){
		if($this->_sql===null){
			$this->_sql=" ( upper($field) $opera upper('$val') COLLATE utf8_general_ci) ";
		} else {
			$this->_sql.="OR ( upper($field) $opera upper('$val') COLLATE utf8_general_ci) ";
		}
		return $this;
	}
	
	public function and($field,$val=true,$opera='='){
		if(count($this->_sql)==0){
			$this->_sql=" ( upper($field) $opera upper('$val') COLLATE utf8_general_ci) ";
		} else {
			$this->_sql.="AND ( upper($field) $opera upper('$val') COLLATE utf8_general_ci) ";
		}
		return $this;
	}
	
	public function sql($_=null){
		if($_===null){
			return $this->_sql;
		}
		$this->_sql=$_;
		return $this;
	}
}
