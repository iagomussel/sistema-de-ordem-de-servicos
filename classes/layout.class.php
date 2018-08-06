<?php

/* classe que gerencia o layout de toda a pagina */

class Layout{
	static private $instance;	
	static private $menuArr=[];
	static private $tableArr=[];
	static private $formArr=[];
	
	
	///-------------------------------------------///
	///    classes html para criação do menu     ///
	///------------------------------------------///
	static private $classByLevel=[
			"ul"=>[
					"class='nav navbar-nav navbar-light bg-light'",
					"class='dropdown-menu'"
			],
			"li"=>[
					"class='dropdown'",
					"class='dropdown-submenu'"
			],
			"a"=>[
					"class='dropdown-toggle' data-toggle='dropdown'"
			 ]
		];
	
	public function __construct(){
		if(isset(self::$instance)) return self::$instance;
		self::$instance = $this;
		
	}
	
	public function addMenuEntry($caminho,$href=NULL,$toggle="tab"){
		if(empty($caminho))return false;
		$title="";
		if(strripos($caminho,'/')){
			$title = substr($caminho,strripos($caminho,'/')+1,strlen($caminho));
		} else {
			$title = $caminho;
		};
		if($href===NULL){
			$href="#".strtolower($title);
		}
		self::$menuArr = self::menuRecurse($caminho,self::$menuArr,new MenuEntry($title,$href,$toggle));
		return true;
	}
	private function menuRecurse($l,$target,$entry){
		if(strpos($l,'/')!== false){
			if(!isset($target[substr($l,0,strpos($l,'/'))])){
				$target[substr($l,0,strpos($l,'/'))]=array();
			}
			$target[substr($l,0,strpos($l,'/'))]=
				self::menuRecurse(
					substr($l,strpos($l,'/')+1,strlen($l)) ,
					$target[substr($l,0,strpos($l,'/'))],
					$entry
					);
			return $target;
		} else {
			$target[$l]=$entry;
			return $target;
		}
		
	}
	private function getClassMenu($node,$lev){
		if(empty(self::$classByLevel[$node]))return "";
		if(isset(self::$classByLevel[$node][$lev])){
			return self::$classByLevel[$node][$lev];
		} else {
			return self::$classByLevel[$node][count(self::$classByLevel[$node])-1];
		};
	}
	private function recursiveMenuDraw($arr,$lev=0){
		echo '<ul '.self::getClassMenu("ul",$lev).'>';
		foreach($arr as $a=>$val){
			if(is_array($val)) {
				echo "<li ".self::getClassMenu("li",$lev)."><a ".self::getClassMenu("a",$lev).">".$a."</a>";
				self::recursiveMenuDraw($arr[$a],$lev+1);
				echo "</li>";	
			} else {
				echo "<li>".$val->htmlEntry()."</li>";
			}
		}
		echo '</ul>';
	}
	public function menuDraw(){
		echo "<nav class='navbar navbar-fixed-top navbar-inverse'><div class='conteiner-fluid'>";
		self::drawHeader();
		echo ' <div class="collapse navbar-collapse" id="myNavbar">';
		self::recursiveMenuDraw(self::$menuArr);
		echo '<ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span>'.$_SESSION["username"].'</a></li>
        <li><a href=""><span class="glyphicon glyphicon-cog"></span></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span></a></li>
      </ul>';
		echo '</div>';
		echo "</div></nav>";
		return true;
	}		
	
	
	/* Cabeçario da pagina */
	public function drawHeader(){
		echo '    <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>                        
		  </button>
		  <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-dashboard"></span></a>
		</div>';			
	}
	
	public function addEntry($qr){
		self::addMenuEntry($qr->Caminho(),$qr->Href());
		self::addTableEntry($qr->Title(),$qr->Href(),$qr->Fields(),$qr->Table());
		self::addFormEntry($qr->Title(),$qr->Href(),$qr->Fields(),$qr->Table());
		return true;
	}
	public function tablesDraw(){
		for($a=0;$a<count(self::$tableArr);$a++){
			if(method_exists(self::$tableArr[$a],"draw")) self::$tableArr[$a]->draw();
		}
	}
	public function addFormEntry($title,$href,$fields,$table){
		self::$formArr[] = new formEntry($title,$href,$fields,$table);
	}
	public function addTableEntry($title,$href,$fields,$table){
		self::$tableArr[] = new TableEntry($title,$href,$fields,$table);
	}
	
	
	public function formsDraw(){
			for($a=0;$a<count(self::$formArr);$a++){
					if(method_exists(self::$formArr[$a],"draw")) self::$formArr[$a]->draw();
			}
	}
}
