<?php

namespace fields;
use formField;
class select extends formField{
	private $type;
	public function __construct($field){
		parent::__construct($field);
		$this->type=$field->type();
	}
	public function draw(){
		echo'<div class="form-group">
			<label for="frm_'.$this->_href.'">'.$this->_name.'</label>
			<select class="form-control" id="'.$this->_href.'" value="'.$this->_default.'" defaultValue="'.$this->_default.'" >
				<option checked="checked">carregando...</option>
			</select>
		</div>';
	}
}