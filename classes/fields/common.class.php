<?php

namespace fields;
use formField;
class common extends formField{
	private $type;
	public function __construct($field){
		parent::__construct($field);
		$this->type=$field->type();
	}
	public function draw(){
		echo'<div class="form-group">';
		if(!in_array($this->type,TYPES_FORM_WITHOUT_LABEL)){
			echo '	<label for="frm_'.$this->_href.'">'.$this->_name.'</label>';
		}
			echo '<input type="'.$this->type.'" class="form-control" id="'.$this->_href.'" name="'.$this->_href.'" value="'.$this->_default.'" defaultValue="'.$this->_default.'"  />
		</div>';
	}
}