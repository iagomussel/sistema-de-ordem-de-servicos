<?php

class formField{
	public $_name;
	public $_href;
	public $_default;
	
	public function __construct(Field $field){
		$this->_name=$field->Title();
		$this->_href=$field->href();
		$this->_default = $field->defaultValue();	
	}
	public function name($_=null){
		if($_===null){
			return $this->_name;
		}
		$this->_name=$_;
		return $this;
	}
	public function href($_=null){
		if($_===null){
			return $this->_href;
		}
		$this->_href=$_;
		return $this;
	}
	public function defaultValue($_=null){
		if($_===null){
			return $this->_default;
		}
		$this->_defaul = $_;
		return $this;
	}	
}
