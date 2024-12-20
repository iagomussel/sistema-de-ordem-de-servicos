<?php
//require("restrict.php");
//require("licence.php");
require("licence.php");
?>
    <!DOCTYPE html>
    <html lang="pt">

    <head>

        <title>Auto Eletrica e Refrigeração</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="css/bootstrap.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-datepicker.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-select.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-dialog.min.css" media="all"/>
        <link rel="stylesheet" href="css/simple-line-icon.css" media="all"/>
        <style  media="all">
			
			.alert{
				position:fixed;
				top:0px;
				left:50%;
				width:50%;
				margin-left:-25%;
			}
			#cabecario_padrao{
				display:none;
			}
            tr.selected {
                outline:solid 2px rgba(16,205,206,1);
            }
			.modal-dialog{
				overflow-y: initial !important
			}
			.modal-body{
				height: 450px;
				overflow-y: auto;
			}
			.only_print{
				display:none;
			}
			th.headerSortUp { 
				background-image: url(img/small_asc.gif); 
				background-color: #ff9933; 
			} 
			th.headerSortDown { 
				background-image: url(img/small_desc.gif); 
				background-color: #3399FF; 
			} th.header { 
				cursor: pointer; 
				font-weight: bold;  
			}

			tbody {
				height: 100px;       /* Just for the demo          */
				overflow-y: auto;    /* Trigger vertical scroll    */
				overflow-x: hidden;  /* Hide the horizontal scroll */
			}
			.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
			padding:0px;
			}
			.table-responsive{
			height: 370px;
			overflow-y:scroll;
			}
			#titulo{
				text-align:center;
				font-size:36pt;
			}	
        </style>
		<style  media="print">
		.table-responsive{
			height: auto;
			overflow-y:overlay;
			}
		#titulo{
			text-align:right;
			font-size:12pt;
		}
		.only_print{
			display:block;
		}
		#cabecario_padrao{
			display:block;
		}
			.noprint{
				display:none
			}
		tr.selected {
                outline:none;
            }
		legend{
			text-align:center;
		}
		.table head{
			position:fixed;
		}
		</style>
        <script src="js/jquery.min.js"></script>
        <script src="js/base64.js"></script>
        <script src="js/gerador.palavras.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap-dialog.min.js"></script>
        <script src="js/bootstrap-confirmation.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-datepicker.pt-BR.min.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
		<script src="js/vue.min.js"></script>
		<script src="js/vue.filters.js"></script>
		<script src="js/corrige.js"></script>
        <script src="index.js"></script>
    </head>

    <body>
		<div class="carregando">
		 <center>
		  <div><h1>InfoStar Automações e informatica</h1></div>
			<img src="img/aguarde.gif" />
		  <div><h4>Carregando conteudo...</h4></div>
		  </center>
		</div>
		
        <div id="container" class="container fade">
            <ul class="nav navbar-static-top nav-tabs navbar-inverse noprint">
				<div class="container-fluid">
					<div class="navbar-header">
					  <a class="navbar-brand" href="#">Sytech | Sistemas de Informação</a>
					</div>
				</DIV>
				<li class="dropdown"> 
					<a class=" dropdown-toggle" type="button" data-toggle="dropdown">Cadastros <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li> <a data-toggle="tab" href="#clientes">		Clientes		</a> </li>
						<li> <a data-toggle="tab" href="#veiculos">		Veiculos		</a> </li>
						<li> <a data-toggle="tab" href="#funcionarios">	Funcionarios	</a> </li>
						<li> <a data-toggle="tab" href="#formpagto">	Formas de Pagto.</a> </li>
						<li> <a data-toggle="tab" href="#condpagto">	Condições de Pagto.</a> </li>
						<li> <a data-toggle="tab" href="#garantias">	Garantias		</a> </li>
					</ul>
				</li>
				<li class="dropdown">
					<a class=" dropdown-toggle" type="button" data-toggle="dropdown">Rotinas <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a data-toggle="tab"  href="#os_s">		Emitir OS</a></li>
						<li><a data-toggle="tab" href="#orcamento">	Orçamento</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class=" dropdown-toggle" type="button" data-toggle="dropdown">Relatórios <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a onclick="mf.relatorios.faturamento()">Faturamento</a></li>
					</ul>
				</li>
                <li>
                    <a data-toggle="tab" href="#suporte"> <span class="icon-suport"></span>Suporte</a>
                </li>
            </ul>
            <div class="tab-content">
				<div id="dashboard" class="tab-pane fade in active">
				
				</div>
                <div id="os_s" class="tab-pane fade ">
                    <form class="form-horizontal">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Ordens de Serviço</legend>
                          
							<div class="input-group input-group-sm noprint">
								<div class="input-group-addon btn btn-primary nova_os_form">Novo<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                                <div class="input-group-addon btn btn-default" onclick="alterar_os_()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
								<div class="input-group-btn">
									<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
									<ul class="dropdown-menu">
									<li><a onclick="mf.relatorios.visualizar('os_s','#os_s_lst')">Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="remove_os()">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
									</ul>
								</div>
								<input type="text" class="search form-control noprint" placeholder="Filtro de pesquisa" target="#os_s_lst" />
                            </div>
							<div class="table-responsive">
                                <table id="os_s_lst" class="table table-hover">
                                      <head><tr>
                                            <th>OS</th>
                                            <th>Data</th>
                                            <th>Cliente</th>
                                            <th>Veiculo</th>
                                            <th>Funcionario</th>
                                            <th>Garantia</th>
                                            <th>Valor</th>
                                        </tr></head>
                                    <tbody class="os_s_table_list">
                                        <tr v-for="r in mf.os_s" v-bind:ind="$index">
											<td>{{r.id}}</td>
											<td>{{r.data}}</td>
											<td>{{r.cliente}}</td>
											<td>{{r.veiculo}}</td>
											<td>{{r.funcionario}}</td>
											<td>{{r.garantia}}</td>
											<td>{{r.valor }}</td>
										</tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </form>
                </div>
				<div id="orcamento" class="tab-pane fade">
                    <form class="form-horizontal">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Orçamento</legend>
                          
							<div class="input-group input-group-sm noprint">
								<div class="input-group-addon btn btn-primary novo_orcamento_form">Novo<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                                <div class="input-group-addon btn btn-default" onclick="alterar_orcamento()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
                                <div class="input-group-btn">
									<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
									<ul class="dropdown-menu">
									
									<li><a onclick="autorizar_orcamento()"> Autorizar Orcamento</a></li>
									<li class="divider"></li>
									<li><a onclick="mf.relatorios.visualizar('orcamentos','#orcamento_lst')">Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="remove_orcamento()">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
									</ul>
								</div>
								<input type="text" class="search form-control noprint" placeholder="Filtro de pesquisa" target="#orcamento_lst" />
                            </div>
							<div class="table-responsive">
                                <table id="orcamento_lst" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Data</th>
                                            <th>Cliente</th>
                                            <th>Veiculo</th>
                                            <th>Funcionario</th>
                                            <th>Garantia</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody class="orcamento_table_list">
                                        <tr v-for="r in mf.orcamentos" v-bind:ind="$index">
											<td>{{r.id}}</td>
											<td>{{r.data}}</td>
											<td>{{r.cliente}}</td>
											<td>{{r.veiculo}}</td>
											<td>{{r.funcionario}}</td>
											<td>{{r.garantia}}</td>
											<td>{{r.valor}}</td>
											
										</tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div id="clientes" class="tab-pane fade">
                    <form class="form-horizontal">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Clientes</legend>
                            <div class="input-group input-group-sm noprint" >
                                <div class="input-group-addon btn btn-primary novo_cliente_form">Novo<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                                <div class="input-group-addon btn btn-default" onclick="alterar_cliente()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
								<div class="input-group-btn">
									<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
									<ul class="dropdown-menu">
									<li><a onclick="mf.relatorios.visualizar('clientes','#clientes_lst')">Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="remove_cliente({{$index}})">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
									</ul>
								</div>
								<input type="text" class="search form-control noprint" placeholder="Filtro de pesquisa" target="#clientes_lst" />
							</div>
                            <div class="table-responsive">
                                
                                <table id="clientes_lst" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cidade</th>
                                            <th>UF</th>
                                            <th>CNPJ/CPF</th>
											
                                        </tr>
                                    </thead>
                                    <tbody class="clientes_table_list">
										<tr v-for="r in mf.clientes" v-bind:ind="$index">
											<td>{{r.nome}}</td>
											<td>{{r.cidade}}</td>
											<td>{{r.estado}}</td>
											<td>{{r.cnpj}}</td>
											
										</tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div id="veiculos" class="tab-pane fade">
                    <form class="form-horizontal">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Veiculos</legend>
                            <div class="input-group input-group-sm noprint">
                                <div class="input-group-addon btn btn-primary novo_veiculos_form">Novo<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                                <div class="input-group-addon btn btn-default" onclick="alterar_veiculo()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
                                <div class="input-group-btn">
									<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
									<ul class="dropdown-menu">
									<li><a onclick="mf.relatorios.visualizar('veiculos','#veiculos_lst')">Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="remove_veiculo()">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
									</ul>
								</div>
								<input type="text" class="search form-control noprint" placeholder="Filtro de pesquisa" target="#veiculos_lst" />
							</div>
                            <div class="table-responsive">
                                
                                <table id="veiculos_lst" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Proprietário</th>
                                            <th>Placa</th>
                                            <th>Modelo</th>
                                            <th>Fabricante</th>
                                            <th>Ano</th>
											
                                        </tr>
                                    </thead>
                                    <tbody class="veiculos_table_list">
										<tr v-for="r in mf.veiculos" v-bind:ind="$index">
											<td>{{r.clienteNome}}</td>
											<td>{{r.placa}}</td>
											<td>{{r.modelo}}</td>
											<td>{{r.fabricante}}</td>
											<td>{{r.ano}}</td>
											
										</tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div id="funcionarios" class="tab-pane fade">
                    <form class="form-horizontal">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Funcionarios</legend>
                            <div class="input-group input-group-sm noprint">
                                <div class="input-group-addon btn btn-primary novo_funcionarios_form">Novo<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
                                <div class="input-group-addon btn btn-default" onclick="alterar_funcionario()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
                                <div class="input-group-btn">
									<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
									<ul class="dropdown-menu">
									<li><a onclick="mf.relatorios.visualizar('funcionarios','#funcionarios_lst')">Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
									<li><a onclick="remove_funcionario()">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
									</ul>
								</div>
								<input type="text" class="search form-control noprint" placeholder="Filtro de pesquisa" target="#funcionarios_lst" />
							</div>
                            <div class="table-responsive">
                                
                                <table id="funcionarios_lst" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Telefone - 1</th>
                                            <th>Telefone - 2</th>
                                            <th>Telefone - 3</th>
											
                                        </tr>
                                    </thead>
                                    <tbody class="funcionarios_table_list">
										<tr v-for="r in mf.funcionarios" v-bind:ind="$index">
											<td>{{r.nome}}</td>
											<td>{{r.telefone1}}</td>
											<td>{{r.telefone2}}</td>
											<td>{{r.telefone3}}</td>
											
											</tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </form>
                </div>
				<div id="formpagto" class="tab-pane fade">
				<form class="form-horizontal">
				  <fieldset>
					<legend>Forma de Pagamento</legend>
					<div class="input-group input-group-sm noprint">
					  <div class="input-group-addon btn btn-primary novo_formpagto_form">Novo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
					   <div class="input-group-addon btn btn-default" onclick="alterar_formpagto()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
					  <div class="input-group-btn">
						<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
						<ul class="dropdown-menu">
						<li class="disabled"><a >Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
						<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
						<li><a onclick="remove_formpagto()">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
						</ul>
					</div>
					<input type="search" class="search form-control noprint" placeholder="Filtro de pesquisa"
					  target="#formpagto_lst" />
					</div>
					<div class="table-responsive">
					  
					  <table id="formpagto_lst" class="table table-striped table-hover">
						<thead>
						  <tr>
							<th>Descrição</th>
						  </tr>
						</thead>
						<tbody class="formpagto_table_list">
							<tr v-for="r in mf.formpagtos" v-bind:ind="$index">
								<td>{{r.descricao}}</td>
							
							</tr>
						</tbody>
					  </table>
					</div>
				  </fieldset>
				</form>
				</div>
				<div id="condpagto" class="tab-pane fade">
				<form class="form-horizontal">
				  <fieldset>
					<legend>Cond. de Pagamento</legend>
					<div class="input-group input-group-sm noprint">
					  <div class="input-group-addon btn btn-primary novo_condpagto_form">Novo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
					  <div class="input-group-addon btn btn-default" onclick="alterar_condpagto()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
					    <div class="input-group-btn">
						<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
						<ul class="dropdown-menu">
						<li class="disabled"><a >Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
						<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
						<li><a onclick="remove_condpagto()">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
						</ul>
					</div>
					  <input type="search" class="search form-control noprint" placeholder="Filtro de pesquisa"
					  target="#condpagto_lst" />
					</div>
					<div class="table-responsive">
					  
					  <table id="condpagto_lst" class="table table-striped table-hover">
						<thead>
						  <tr>
							<th>Forma de Pagamento</th>
							<th>Descrição</th>
						  </tr>
						</thead>
						<tbody class="formpagto_table_list">
							<tr v-for="r in mf.condpagtos" v-bind:ind="$index">
								<td>{{r.formpagto_descricao}}</td>
								<td>{{r.descricao}}</td>
							</tr>
						</tbody>
					  </table>
					</div>
				  </fieldset>
				</form>
				</div>
				<div id="garantias" class="tab-pane fade">
				<form class="form-horizontal">
				  <fieldset>
					<legend>Garantias</legend>
					<div class="input-group input-group-sm noprint">
						<div class="input-group-addon btn btn-primary novo_garantia_form">Novo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
						<div class="input-group-addon btn btn-default" onclick="alterar_garantias()">Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></div>
						  <div class="input-group-btn">
						<a class="input-group-addon btn btn-default dropdown-toggle" data-toggle="dropdown" > <span class="caret" aria-hidden="true"></span></a>
						<ul class="dropdown-menu">
						<li class="disabled"><a >Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
						<li><a onclick="window.print()">Imprimir Lista <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></li>
						<li><a onclick="remove_garantia()">Remover <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
						</ul>
					</div><input type="search" class="search form-control noprint" placeholder="Filtro de pesquisa"
					  target="#garantias_lst" />
					</div>
					<div class="table-responsive">
					  
					  <table id="garantias_lst" class="table table-striped table-hover">
						<thead>
						  <tr>
							<th>Descrição</th>
						  </tr>
						</thead>
						<tbody class="garantias_table_list">
						   <tr v-for="r in mf.garantias" v-bind:ind="$index">
								<td>{{r.descricao}}</td>
								
							</tr>
						</tbody>
					  </table>
					</div>
				  </fieldset>
				</form>
				</div>
                <div id="suporte" class="tab-pane fade">
				
				<div>
					<div class="row">
						
						<div class="col-md-offset-4 col-md-4">
						<h4>Sytech desenvolvimentos</h4>
							<p>Licenciado Para: Auto Eletrica e Refrigeração Ltda.</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12	">
							<center>
							<h4>Para mais produtos entre em contato com nosso suporte.
							</h4>
					
						<h4>contato</h4>
							<p>tel.:(21) 98698 - 6143</p>
							<p>E-mail:himmussel@gmail.com</p>
							<p>contato:him_mussel@live.com</p>
							<p></p>
							</center>
						</div>
					</div>
				</div>
				</div>
			</div>
            
			<div id="form_os_s_modal" class="modal fade" role="dialog"> <!-- OS -->
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title">Emitir Ordem de Serviço</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <fieldset>
					<legend data-toggle="collapse" data-target="#dados_os">Dados Gerais da O.S.</legend>
					<div id="dados_os" class="collapse in">
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="data">Data</label>
                            <div class="col-md-4">
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
									<input id="data" name="data" v-model="mf.forms.os_s.data" mask="##/##/####" type="text" type="text" class="form-control">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
								
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="cliente">Cliente</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_cliente_form">
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
									<select   id="cliente"   name="cliente" v-model="mf.forms.os_s.cliente"  class="form-control" variavel="clientes_select_list" value="" required="" >
										<option v-for="r in mf.clientes" v-bind:value="r.id">{{r.nome}}</option>
									</select>
								</div>
                            </div>
                        </div>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="veiculo">Veiculo</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
											<div class="input-group-addon btn novo_veiculos_form" ><div ><span class="glyphicon glyphicon-plus"></span></div></div>
											<select id="veiculo" v-model="mf.forms.os_s.veiculo" name="veiculo" value=""
											class="form-control " variavel="veiculos_select_list" required="" >
												<option v-for="r in mf.veiculos| filterBy mf.forms.os_s.cliente in 'cliente'" v-bind:value="r.id">{{r.placa}}</option>
											</select>
										</div>
                                    </div>
                                </div>
								<!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="funcionario">Funcionario</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_funcionarios_form"  aria-expanded="true">
										<div>
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="funcionario" name="funcionario" v-model="mf.forms.os_s.funcionario" Value value="" class="form-control  " variavel="funcionarios_select_list" required="" >
											<option v-for="r in mf.funcionarios" v-bind:value="r.id">{{r.nome}}</option>
									</select>
								</div>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-4 control-label" for="formpagto">Forma Pagto.</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_formpagto_form"  aria-expanded="true">
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="formpagto" v-model="mf.forms.os_s.formpagto"  name="formpagto" Value class="form-control " variavel="formpagto_select_list" value="" required="" >
											<option v-for="r in mf.formpagtos" v-bind:value="r.id">{{r.descricao}}</option>
									</select>
								</div>
                            </div>
                        </div>
						<div class="form-group">
                        <label class="col-md-4 control-label" for="formpagto">Condição Pagto.</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_condpagto_form"  aria-expanded="true">
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="formpagto" v-model="mf.forms.os_s.condpagto"  name="formpagto" Value class="form-control " variavel="formpagto_select_list" value="" required="" >
											<option v-for="r in mf.condpagtos | filterBy mf.forms.os_s.formpagto in 'formpagto'" v-bind:value="r.id">{{r.descricao}}</option>
									</select>
								</div>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-4 control-label" for="garantia">Garantia</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_garantia_form" >
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="garantia" v-model="mf.forms.os_s.garantia" name="garantia" Value class="form-control" variavel="garantia_select_list" value="" required="" >
											<option v-for="r in mf.garantias" v-bind:value="r.id">{{r.descricao}}</option>
									</select>
								</div>
                            </div>
                        </div>
                    </div>
								</fieldset>
								
								<fieldset>
								<legend data-toggle="collapse" data-target="#desc_serv">Descrição dos serviços</legend>
							<div id="desc_serv" class="collapse in well">
                                <!-- Textarea -->
                                <div class="form-group">
                                    
                                    <div class="col-md-offset-2 col-md-8">
									<div class="table-responsive">
                                        <table class="oneton table-hover table-striped">
											<thead>
											  <tr >
												<th>Quantidade</th>
												<th>Serviços</th>
												<th>V. Unit</th>
												<th>Valor Total</th>
												<th>&times;</th >
												</tr>
											</thead>
											<tbody id="os_xservico">
											<tr v-for="i in mf.forms.os_s.servicos">
											  <td><input type="number" class="form-control input-sm" name="quantidade"  v-model="i.quantidade" /></td>
											  <td><input type="text" class="form-control input-sm" name="servico"  v-model="i.servico" /></td>
											  <td><input type="number" class="form-control input-sm" name="valorunit"  v-model="i.valorunit" /></td>
											  <td><input type="number" readonly class="form-control input-sm" name="valortotal"  v-model="i.valorunit*i.quantidade"/></td>
											  <td class="btn btn-default close" onclick="remove_os_x_servico({{$index}})">&times;</td>
											 </tr>
											</tbody>
										  </table>
									</div>
                                    </div>
                                </div>
								 <div class="form-group">
								 <div class="col-md-offset-3 col-md-6">
								 <div class="btn btn-default" onclick="novo_os_x_servico()">Novo</div></div>
								 </div>
								</div>
								</fieldset>
                            
							<fieldset>
							<legend data-toggle="collapse" data-target="#dados_ad">Dados Adcionais</legend>
					<div id="dados_ad" class="collapse in">
						<div class="form-group">
                                    
                                    <div class="col-md-offset-2 col-md-8">
                                       <textarea id="observacao" v-model="mf.forms.os_s.observacao" name="observacao"  class="form-control input-md" required="" ></textarea>  
								   </div>
                        </div>
					</div>
							</fieldset>
							</form>
                        </div>
			<div class="modal-footer">
				<div type="button" class="btn btn-primary"  onclick="grava_os_()">Gravar</div> 
				<div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div>
			</div>
		</div>
	</div>
            </div>
			<!-- OS FIM -->
			<div id="form_orcamento_modal" class="modal fade" role="dialog"><!-- ORÇAMENTO -->
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div type="button" class="close" data-dismiss="modal">&times;</div>
                <h4 class="modal-title">Orçamentos</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <fieldset>
					<legend data-toggle="collapse" data-target="#dadoorcamentoos">Fazer um orçamento</legend>
					<div id="dadorcamentoos" class="collapse in">
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="data">Data</label>
                            <div class="col-md-4">
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
									<input id="data" name="data" v-model="mf.forms.orcamentos.data" mask="##/##/####" type="text" type="text" class="form-control">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
								
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="cliente">Cliente</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_cliente_form">
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select   id="cliente"   name="cliente" v-model="mf.forms.orcamentos.cliente"  class="form-control" variavel="clientes_select_list" value="" required="" >
										<option v-for="r in mf.clientes" v-bind:value="r.id">{{r.nome}}</option>
									</select>
								</div>
                            </div>
                        </div>
                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="veiculo">Veiculo</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
											<div class="input-group-addon btn novo_veiculos_form"><div ><span class="glyphicon glyphicon-plus"></span></div></div>
											<select id="veiculo" v-model="mf.forms.orcamentos.veiculo" name="veiculo" value=""
											class="form-control " variavel="veiculos_select_list" required="" >
												<option v-for="r in mf.veiculos| filterBy mf.forms.orcamentos.cliente in 'cliente'" v-bind:value="r.id">{{r.placa}}</option>
											</select>
										</div>
                                    </div>
                                </div>
								<!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="funcionario">Funcionario</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_funcionarios_form">
									<div>
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="funcionario" name="funcionario" v-model="mf.forms.orcamentos.funcionario" class="form-control  " variavel="funcionarios_select_list" required="" >
											<option v-for="r in mf.funcionarios" v-bind:value="r.id">{{r.nome}}</option>
									</select>
								</div>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-4 control-label" for="formpagto">Forma Pagto.</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_formpagto_form" >
									<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="formpagto" v-model="mf.forms.orcamentos.formpagto"  name="formpagto" Value class="form-control " variavel="formpagto_select_list" value="" required="" >
											<option v-for="r in mf.formpagtos" v-bind:value="r.id">{{r.descricao}}</option>
									</select>
								</div>
                            </div>
                        </div>
						<div class="form-group">
                        <label class="col-md-4 control-label" for="formpagto">Condição Pagto.</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_condpagto_form">
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="formpagto" v-model="mf.forms.orcamentos.condpagto"  name="formpagto" Value class="form-control " variavel="formpagto_select_list" value="" required="" >
											<option v-for="r in mf.condpagtos | filterBy mf.forms.orcamentos.formpagto in 'formpagto'" v-bind:value="r.id">{{r.descricao}}</option>
									</select>
								</div>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-4 control-label" for="garantia">Garantia</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_garantia_form" >
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="garantia" v-model="mf.forms.orcamentos.garantia" name="garantia" Value class="form-control" variavel="garantia_select_list" value="" required="" >
											<option v-for="r in mf.garantias" v-bind:value="r.id">{{r.descricao}}</option>
									</select>
								</div>
                            </div>
                        </div>
                    </div>
								</fieldset>
								
								<fieldset>
								<legend data-toggle="collapse" data-target="#desc_serv">Descrição dos serviços</legend>
							<div id="desc_serv" class="collapse in well">
                                <!-- Textarea -->
                                <div class="form-group">
                                    
                                    <div class="col-md-offset-2 col-md-8">
									<div class="table-responsive">
                                        <table class="oneton table-hover table-striped">
											<thead>
											  <tr >
												<th>Quantidade</th>
												<th>Serviços</th>
												<th>V. Unit</th>
												<th>Valor Total</th>
												<th>&times;</th >
												</tr>
											</thead>
											<tbody id="orcamentoxservico">
											<tr v-for="i in mf.forms.orcamentos.servicos">
											  <td><input type="number" class="form-control input-sm" name="quantidade"  v-model="i.quantidade" /></td>
											  <td><input type="text" class="form-control input-sm" name="servico"  v-model="i.servico" /></td>
											  <td><input type="number" class="form-control input-sm" name="valorunit"  v-model="i.valorunit" /></td>
											  <td><input type="number" readonly class="form-control input-sm" name="valortotal"  v-model="i.valorunit*i.quantidade"/></td>
											  <td class="btn btn-default close" onclick="remove_orcamento_x_servico({{$index}})">&times;</td>
											 </tr>
											</tbody>
										  </table>
									</div>
                                    </div>
                                </div>
								 <div class="form-group">
								 <div class="col-md-offset-3 col-md-6">
								 <div class="btn btn-default" onclick="novo_orcamento_x_servico()">Novo</div></div>
								 </div>
								</div>
								</fieldset>
                            
							<fieldset>
							<legend data-toggle="collapse" data-target="#dadorcamentoad">Dados Adicionais</legend>
					<div id="dadorcamentoad" class="collapse in">
					<div class="form-group">
                                    
                                    <div class="col-md-offset-2 col-md-8">
                                        <textarea id="observacao" v-model="mf.forms.orcamentos.observacao" name="observacao"  class="form-control input-md" required="" ></textarea>
                                    </div>
                                </div>
					</div>
							</fieldset>
							</form>
                        </div>
                        <div class="modal-footer">
                        <div type="button" class="btn btn-primary"  onclick="grava_orcamento()">Gravar</div> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
                </div>
            </div>
            <!-- ORÇAMENTO FIM -->
			<?PHP 
				include("forms/clientes_frm.php")
			?>
			<div id="form_funcionarios_modal" class="modal fade" role="dialog"><!-- FUNCIONARIO -->
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Funcionarios</h4>
                        </div>
                        <div class="modal-body">
						
						<form class="form-horizontal">
							<fieldset>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="nome">Nome</label>  
							  <div class="col-md-4">
							  <input id="nome" name="nome" type="text" placeholder="Nome" v-model="mf.forms.funcionarios.nome" class="form-control input-md" required="">
								
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="telefone1">Telefone</label>  
							  <div class="col-md-4">
							  <input id="telefone1" name="telefone1" v-model="mf.forms.funcionarios.telefone1" type="text" placeholder="Telefone" class="form-control input-md">
								
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label"  for="telefone2">Telefone</label>  
							  <div class="col-md-4">
							  <input id="telefone2" name="telefone2" v-model="mf.forms.funcionarios.telefone2" type="text" placeholder="Telefone" class="form-control input-md">
								
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="telefone3">Telefone</label>  
							  <div class="col-md-4">
							  <input id="telefone3" name="telefone3" v-model="mf.forms.funcionarios.telefone3" type="text" placeholder="Telefone" class="form-control input-md">
								
							  </div>
							</div>

							</fieldset>
							</form>

						
						</div>
                        <div class="modal-footer">
                        <div type="button" class="btn btn-primary" onclick="grava_funcionario()">Gravar</div> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
                </div>
            </div>
            <!-- FUNCIONARIO FIM-->
			<div id="form_veiculos_modal" class="modal fade" role="dialog"><!-- VEICULOS -->
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Veiculos</h4>
                        </div>	
                        <div class="modal-body">
						<form class="form-horizontal">
							<fieldset>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="cliente">Cliente Proprietário</label>  
							  <div class="col-md-4">
									<select id="cliente" name="cliente" v-model="mf.forms.veiculos.cliente" class="form-control " variavel="clientes_select_list" value="" required="" >
										<option v-for="r in mf.clientes" v-bind:value="r.id">{{r.nome}}</option>
									</select>
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="placa">Placa</label>  
							  <div class="col-md-4">
							  <input id="placa" name="placa" v-model="mf.forms.veiculos.placa" type="text" placeholder="Placa" class="form-control input-md" required="">
								
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="fabricante">Fabricante</label>  
							  <div class="col-md-4">
							  <input id="fabricante" name="fabricante" v-model="mf.forms.veiculos.fabricante" type="text" placeholder="Fabricante" class="form-control input-md" required="">
								
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="modelo">Modelo</label>  
							  <div class="col-md-4">
							  <input id="modelo" name="modelo" type="text" v-model="mf.forms.veiculos.modelo" placeholder="modelo" class="form-control input-md">
								
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="ano">Ano</label>  
							  <div class="col-md-4">
							  <input id="ano" name="ano" type="text"  v-model="mf.forms.veiculos.ano" placeholder="Ano" class="form-control input-md">
								
							  </div>
							</div>

						

							</fieldset>
							</form>
						</div>
                        <div class="modal-footer">
                        <div type="button" class="btn btn-primary" onclick="grava_veiculo()">Gravar</div> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
                </div>
            </div>
			<!-- VEICULOS FIM -->
			<div id="form_formpagto_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Forma Pagto.</h4>
                        </div>	
                        <div class="modal-body">
						<form class="form-horizontal">
							<fieldset>
							

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="descricao">Descrição</label>  
							  <div class="col-md-4">
							  <input id="descricao" name="descricao" v-model="mf.forms.formpagtos.descricao" type="text" placeholder="B O L E T O" class="form-control input-md" required="">
								
							  </div>
							</div>

							
							</fieldset>
							</form>
						</div>
                        <div class="modal-footer">
                        <div type="button" class="btn btn-primary" onclick="grava_formpagto()">Gravar</div> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
                </div>
            </div>
			<div id="form_condpagto_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Condição Pagto.</h4>
                        </div>	
                        <div class="modal-body">
						<form class="form-horizontal">
							<fieldset>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="formpagto">Forma de pagamento para esta condição</label>  
							  <div class="col-md-4">
							  <select id="formpagto" name="formpagto" v-model="mf.forms.condpagtos.formpagto" type="text" placeholder="30 / 60 DD" class="form-control input-md" required="">
								<option v-for="l in mf.formpagtos" :value="l.id" >{{l.descricao}}</option>
							  </select>
							  </div>
							</div>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="descricao">Descrição</label>  
							  <div class="col-md-4">
							  <input id="descricao" name="descricao" v-model="mf.forms.condpagtos.descricao" type="text" placeholder="30 / 60 DD" class="form-control input-md" required="">
								
							  </div>
							</div>

							
							</fieldset>
							</form>
						</div>
                        <div class="modal-footer">
                        <div type="button" class="btn btn-primary" onclick="grava_condpagto()">Gravar</div> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
                </div>
            </div>
			<div id="form_garantias_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Garantias</h4>
                        </div>	
                        <div class="modal-body">
						<form class="form-horizontal">
							<fieldset>
							

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="descricao">Descrição</label>  
							  <div class="col-md-4">
							  <input id="descricao" name="descricao" v-model="mf.forms.garantias.descricao" type="text" placeholder="30 / DD" class="form-control input-md" required="">
								
							  </div>
							</div>

							
							</fieldset>
							</form>
						</div>
                        <div class="modal-footer">
                        <div type="button" class="btn btn-primary" onclick="grava_garantia()">Gravar</div> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
                </div>
            </div>
			<div id="form_faturamento_modal" class="modal fade" >
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Faturamento</h4>
                        </div>	
                        <div class="modal-body">
						<form class="form-horizontal">
							<fieldset>
							<!-- data inicial-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="data_inicial">Periodo</label>  
							  <div class="col-md-4">
							  <div class="input-group input-daterange" data-provide="datepicker" data-date-format="dd/mm/yyyy">
									<input type="text" class="form-control" mask="##/##/####"
									v-model="mf.relatorios.forms.faturamento.data_inicial">
									<span class="input-group-addon">A</span>
									<input type="text" class="form-control" mask="##/##/####"
									v-model="mf.relatorios.forms.faturamento.data_final">
								</div>
							  </div>
							</div>


							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="descricao">Ordenar por</label>  
							  <div class="col-md-4">
								  <select id="order" name="order" value="dia" v-model="mf.relatorios.forms.faturamento.ordenar_por" class="form-control " >
									  
									  <option value="data">Data</option>
									  <option value="cliente">Cliente</option>
									  <option value="funcionario">Funcionario</option>
									  <option value="veiculo">Veiculo</option>
								  </select>
							  </div>
							</div>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="graficos">Incluir Graficos?</label>  
							  <div class="col-md-4">
								  <select id="graficos" name="graficos" v-model="mf.relatorios.forms.faturamento.graficos" data-live-search="1" class="form-control " >
									  <option value="1" selected>Sim</option>
									  <option value="0">Nao</option>
								  </select>
							  </div>
							</div>
							<div class="form-group" v-show="mf.relatorios.forms.faturamento.graficos == 1">
							  <label class="col-md-4 control-label" for="tipo_graf">Tipo Grafico?</label>  
							  <div class="col-md-4">
								  <select id="tipo_graf" v-model="mf.relatorios.forms.faturamento.tipo_graf" name="tipo_graf" value="pie" Value class="form-control " >								  
									  <option value="pie">Pizza</option>
									  <option value="line">Linha</option>
									  <option value="bar">Barras</option>
									  <option value="radar" selected >Radar</option>
									  <option value="polarArea">Area Polar</option>
								  </select>
							  </div>
							</div>
							</fieldset>
							</form>
						</div>
                        <div class="modal-footer">
						
                        <a target="_black" href="relatorios.php?tipo=faturamento&ordenar_por={{mf.relatorios.forms.faturamento.ordenar_por}}&tipo_graf={{mf.relatorios.forms.faturamento.tipo_graf}}&graficos={{mf.relatorios.forms.faturamento.graficos}}&data_inicial={{mf.relatorios.forms.faturamento.data_inicial}}&data_final={{mf.relatorios.forms.faturamento.data_final}}" type="button" class="btn btn-primary">Imprimir</a> 
                       	<div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
					
					
                </div>
				
        </div>
			<div id="relatorios_visualizar" class="modal fade" >
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Visualizaror</h4>
                        </div>	
                        <div class="modal-body">
						<form class="form-horizontal">
						
							
							<fieldset v-show="mf.relatorios.forms.visualizar.periodo">
							<!-- data inicial-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="data_inicial">Periodo</label>  
							  <div class="col-md-4">
							  <div class="input-group input-daterange" data-provide="datepicker" data-date-format="dd/mm/yyyy">
									<input type="text" class="form-control" mask="##/##/####"
									v-model="mf.relatorios.forms.visualizar.data_inicial">
									<span class="input-group-addon">A</span>
									<input type="text" class="form-control" mask="##/##/####"
									v-model="mf.relatorios.forms.visualizar.data_final">
								</div>
							  </div>
							</div>
							
							</fieldset>
							<div class="table-responsive">
							<table class="table table-striped table-hover ">
								<tr><td>Descricao</td><td>{{mf.relatorios.forms.visualizar.descricao}}</td></tr>
								<tr><td>ID / Codigo interno</td><td>{{mf.relatorios.forms.visualizar.id}}</td></tr>
							</table>
							</div>
							</form>
						</div>
                        <div class="modal-footer">
                        <a target="_black" href="relatorios.php?tipo=visualizador&local={{mf.relatorios.forms.visualizar.local}}&id={{mf.relatorios.forms.visualizar.id}}&data_inicial={{mf.relatorios.forms.visualizar.data_inicial}}&data_final={{mf.relatorios.forms.visualizar.data_final}}" type="button" class="btn btn-primary">Imprimir</a> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
					
					
                </div>
				
        </div>	
        </div>
		<img style="position:fixed;bottom:0px;right:0px;display:none" class="carregando_sutil" src="img/carregando_sutil.gif"/>
    </body>
</html>