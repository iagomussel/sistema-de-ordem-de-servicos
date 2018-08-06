<form class="form-horizontal" id="form_os">
                    <fieldset>
					<legend data-toggle="collapse" data-target="#dados_os">Dados Gerais da O.S.</legend>
					<div id="dados_os" class="collapse in">
                        <!-- Text input-->
                        <div class="col-md-2">
                            <label class=" control-label" for="data">Data</label>
                            <div class="">
                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
									<input id="data" name="data" v-model="mf.forms.os_s.data" mask="##/##/####" type="text" type="text" class="form-control">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
								
                            </div>
                        </div>
						
						<div class="col-md-2">
                            <label class="control-label" for="garantia">Tipo do atendimento</label>
                            <div class="">
                                     <select name="tipo" id="tipo" text="{{descricao}}"  url="<?php echo Qr::inst("tipoatendimentoos")->table();?>" class="select2 form-control" value="" required="" >
									</select>		 
							</div>
                        </div>
                        <!-- Text input-->
                        <div class=" col-md-5">
                            <label class="control-label" for="cliente">Cliente</label>
                            <div >
                                <div class="input-group">
                                    <div class="input-group-addon ">
										<div onclick="novo_registro('<?php echo Qr::inst("clientes")->href();?>',function(dat){ console.log(event) })" >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
									 <select   id="cliente"   name="cliente" text="{{nome}}"  url="<?php echo Qr::inst("clientes")->table();?>" class="select2 form-control" value="" required="" >
									</select>
								   
								</div>
                            </div>
                        </div>
						
                                <!-- Text input-->
                                <div class="col-md-3">
                                    <label class="control-label" for="veiculo">Veiculo</label>
                                    <div class="">
                                        <div class="input-group">
											<div class="input-group-addon "onclick="novo_registro('<?php echo Qr::inst("veiculos")->href();?>',function(dat){ console.log(event) })" ><div ><span class="glyphicon glyphicon-plus"></span></div></div>
											<select id="veiculo"  name="veiculo" url="<?php echo Qr::inst("veiculos")->table();?>"
											class="select2" text="{{placa}}" required="" >
											</select>
										</div>
                                    </div>
                                </div>
								<!-- Text input-->
								
								<div class="col-md-4">
                            <label class="control-label" for="funcionario">Funcionario</label>
                            <div class="">
                                <div class="input-group">
                                    <div class="input-group-addon"  onclick="novo_registro('<?php echo Qr::inst("clientes")->href();?>',function(dat){ console.log(event) })" >
									<div>
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="funcionario" name="funcionario" text="{{nome}}" url="<?php echo Qr::inst("funcionarios")->table();?>" class="select2" required="" >
									</select>
								</div>
                            </div>
                        </div>
						
						<div class="col-md-5">
                            <label class="control-label" for="formpagto">Forma Pagto.</label>
                            <div class="">
                                <div class="input-group">
                                    <div class="input-group-addon btn" onclick="novo_registro('<?php echo Qr::inst("formpagtos")->href();?>',function(dat){ console.log(event) })"  aria-expanded="true">
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="formpagto" name="formpagto" class="select2" url="<?php echo Qr::inst("formpagtos")->table();?>" text="{{descricao}}" required="" >
									</select>
								</div>
                            </div>
                        </div>
						<div class="col-md-3">
                        <label class="control-label" for="condpagto">Parcelamento</label>
                            <div class="">
                                <div class="input-group">
                                    <div class="input-group-addon btn novo_condpagto_form"  aria-expanded="true">
										<div onclick="novo_registro('<?php echo Qr::inst("condpagtos")->href();?>',function(dat){ console.log(event) })">
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="condpagto"  name="condpagto" url="<?php echo Qr::inst("condpagtos")->table();?>" text="{{descricao}}" class="select2" required="" >				</select>
								</div>
                            </div>
                        </div>
						<div class="col-md-4">
                            <label class="control-label" for="garantia">Garantia</label>
                            <div class="">
                                <div class="input-group">
                                    <div class="input-group-addon btn" onclick="novo_registro('<?php echo Qr::inst("garantias")->href();?>',function(dat){ console.log(event) })">
										<div >
										<span class="glyphicon glyphicon-plus"></span></div>
									</div>
                                    <select id="garantia" name="garantia" url="<?php echo Qr::inst("garantias")->table();?>" class="select2" text="{{descricao}}" required="" >
									</select>
								</div>
                            </div>
                        </div>
						<div class="col-md-3">
                            <label class="control-label" for="garantia">Situação</label>
                            <div class="">
                                    <select id="situacao" name="situacao" class="form-control" >
											<option value="0">Em aberto</option>
											<option value="1">Finalizado</option>
											<option value="2">Cancelado</option>
									</select>
                            </div>
                        </div>
						
                    </div>
								</fieldset>
								
								<fieldset>
								<legend data-toggle="collapse" data-target="#desc_serv">Descrição dos serviços</legend>
								<div id="desc_serv" class="collapse in">
                                <!-- Textarea -->
                                <div class="form-group">
                                    
                                    <div class="table-responsive">
										<div class="table-with-form-add">+</div>
                                        <table class="table table-with-form">
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
											<tr>
											  <td><input type="number" class="form-control input-sm" name="servico.quantidade"  /></td>
											  <td><input type="text" class="form-control input-sm" name="servico.servico"  /></td>
											  <td><input type="number" class="form-control input-sm" name="servico.valorunit"  /></td>
											  <td><input type="number" readonly class="form-control input-sm" name="valortotal" /></td>
											  <td class="btn btn-default table-with-form-close">&times;</td>
											 </tr>
											</tbody>
										  </table>
									</div>
                                    </div>
                        
								 </div>
								</fieldset>
                            
							<fieldset>
							<legend data-toggle="collapse" data-target="#dados_ad">Dados Adicionais</legend>
					<div id="dados_ad" class="collapse in">
						<div class="form-group">
                                    
                                       <textarea id="observacao" name="observacao"  class="form-control input-md" required="" ></textarea>  

                        </div>
					</div>
							</fieldset>
							</form>