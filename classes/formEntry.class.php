<?php

class formEntry{
	protected $_fields=[];
	private $_href="";
	private $_title="";
	private $_table="";
	
	public function __construct($title,$href,$fields,$table){
		$this->_href=($href===NULL)?$title:$href;
		$this->_title=$title;
		$this->_table=($table===NULL)?$title:$table;
		if(!file_exists("app/view/forms/".$this->_table.".frm.html")){
			foreach($fields as $field){
				switch($field->type()){
					case 'date':
					case 'data':
						$this->fields[] = new Fields\data($field);
					break;
					default:
						$this->fields[] = new Fields\common($field);	
					break;
				}
			}
		}
	}
	public function draw(){
		
		echo '<div id="'.$this->_href.'_form" url="'.$this->_table.'" class="tab-pane fade">';  
	  if(file_exists("app/view/forms/".$this->_table.".frm.php")){
		require("app/view/forms/".$this->_table.".frm.php");
	  } else {
		echo '<form>';
			foreach($this->fields as $field){
				echo '<div>';
				$field->draw();
				echo '</div>';
			}
		echo '</form>';
	  }
	  echo '
      <div class="panel-footer">
        <button type="button" class="btn btn-primary gravar_btn">Gravar</button>
        <button type="button" class="btn btn-default return_tab">Voltar</button>
      </div>
	  </div>';
	}
}