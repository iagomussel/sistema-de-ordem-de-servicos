<?php
class Query{
	protected static $_query;
	protected static $est;
	public function __construct(){
		self::$_query = array();
	}
	public	function get_return(){
		if(isset(self::$_query)){
			return self::$_query;
		} else {
			new Query();
			return self::$_query;	
		}
	}
	public function json($pretty=true){
		header("Content-Type: application/json");
		if($pretty)
			print json_encode(self::$_query,JSON_PRETTY_PRINT);
		else
			print json_encode(self::$_query);
	}
	public function erro($str="", $parar=false){
		if(!isset(self::$_query["error"])) self::$_query["error"]=array();
		self::$_query["error"][]=$str;
		if($parar){
			self::json();
			die();
		}
	}
	public function data($_data=null){
		if(!isset(self::$_query["data"]))self::$_query["data"]=array();
		if($_data === null)return self::$_query["data"];
		
		if(!isset(self::$_query))self::$_query=array();
		self::$_query["data"] = $_data;
	}
	
	public function paginate($atual=null,$de=null){
		if($atual===null && $de===null){
			return self::$_query["paginacao"];
		}
		if(!isset(self::$_query))self::$_query=array();
		self::$_query["paginacao"] = array("atual"=>$atual,"ultima"=>$de);
	}
	public function request($_data){
		if(!isset(self::$_query))self::$_query=array();
		self::$_query["request"] = $_data;
	}
}
?>