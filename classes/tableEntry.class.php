<?php
class TableEntry{
	private $_fields=[];
	private $_href="";
	private $_title="";
	private $_table="";
	public function __construct($title,$href=NULL,$fields,$table=null){
		
		$this->_fields=$fields;
		$this->_href=($href===NULL)?$title:$href;
		$this->_title=$title;
		$this->_table=($table===NULL)?$title:$table;
	}
	public function draw(){
		//obtem os dados da pagina 1;
			$table = qr::inst($this->_table);
			$table->consulta();
			$resp = Query::data();
			$pagination = Query::paginate();
		//abre a teb, form e titulo
		
		
		echo '<div id="'.$this->_href.'" class="tab-pane fade">
                    <form class="form-horizontal">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>'.$this->_title.'</legend>';
		// imprime o menu de açoes e search box
		echo ' 				<div class="input-group input-group-sm noprint" >
                                <div class="input-group-addon btn btn-primary" onclick="novo_registro(\''.    $this->_href.'\')"><span class="glyphicon glyphicon-plus"   aria-hidden="true"></span></div>
                                <div class="input-group-addon btn btn-default" onclick="alterar_registro(\''. $this->_href.'\')"><span class="glyphicon glyphicon-edit"   aria-hidden="true"></span></div>
								<div class="input-group-addon btn btn-default" onclick="imprimir_registro(\''.$this->_href.'\')"><span class="glyphicon glyphicon-print"  aria-hidden="true"></span></div>
								<div class="input-group-addon btn btn-default" onclick="excluir_registro( \''.$this->_href.'\')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div>
								<div class="input-group-btn">
									<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
									<ul class="dropdown-menu">
									<li><a onclick="window.print()">Listar <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									</ul>
								</div>
								<input type="text" class="search form-control noprint" placeholder="Filtro de pesquisa" url=\''.$this->_table.'\' target="'.$this->_href.'" />
							</div>
                           ';
						   
		//imprime a tabela de dados
		echo '                <div class="table-responsive">
                                
                                <table class="table">
                                    <thead>
                                        <tr>';
										//loop do cabeçario da tabela
		
		for($a=0;$a<count($this->_fields);$a++){
				if($this->_fields[$a]->display())
					echo "<th>".$this->_fields[$a]->title()."</th>";
		}
		
		echo '                      <th></th>  </tr>
                                    </thead>
                                    <tbody class="table_list">';
									
			echo '</tr>';
		
										
										
										
		//fecha a tabela, form e tab-pane
		echo '							</tr>
                                    </tbody>
                                </table>
                            </div><div class="pagination_div"></div>';
		
		echo '
                        </fieldset>
                    </form>
                </div>
               <script>
			   $(document).ready(function(){
					paginate("' .$this->_href. '",'.json_encode($pagination).')
				})	
			   </script>
			   ';
	}
}


 
            
                                            