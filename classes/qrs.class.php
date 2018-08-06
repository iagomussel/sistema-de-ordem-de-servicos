<?php

class Qrs{
	public static $tabelas=[];
	public function table($table,$href=NULL){
		if(empty($table))return false;
		if(strpos($table,"/")){
			$title = strtolower(substr($table,strripos($table,'/')+1,strlen($table)));
			self::$tabelas[$title] = new qr($table,$href);
			return self::$tabelas[$title];
		}
		if(isset(self::$tabelas[strtolower($table)])){
			return self::$tabelas[strtolower($table)];
		} else return false;
	}
}