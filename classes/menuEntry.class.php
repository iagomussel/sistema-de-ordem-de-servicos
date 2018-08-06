<?php

class MenuEntry{
	public $href;
	public $toggle;
	public $title;
	public function __construct($_title,$_href,$_toggle){
		$this->href =$_href;
		$this->toggle=$_toggle;
		$this->title=$_title;
	}
	public function htmlEntry(){
		return "<a href='#".$this->href."' data-toggle='".$this->toggle."'>".$this->title."</a>";
	}
}
