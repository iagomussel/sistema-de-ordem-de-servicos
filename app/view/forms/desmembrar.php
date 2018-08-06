
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