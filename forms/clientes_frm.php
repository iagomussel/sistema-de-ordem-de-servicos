<!-- CLIENTE -->

			<div id="form_clientes_modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <div type="button" class="close" data-dismiss="modal">&times;</div>
                            <h4 class="modal-title">Clientes</h4>
                        </div>
                        <div class="modal-body">
						
						<form class="form-horizontal">
							<fieldset>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="cnpj">CNPJ</label>  
							  <div class="col-md-4">
							  <input id="cnpj_cliente" name="cnpj" v-model="mf.forms.clientes.cnpj" type="text" placeholder="00.000.000/0000-000" class="form-control input-md">
								
							  </div>
							</div>
							
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="nome">Nome</label>  
							  <div class="col-md-4">
							  <input id="nome" name="nome" type="text" v-model="mf.forms.clientes.nome" placeholder="Nome" class="form-control input-md" required="">
								
							  </div>
							</div>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="cidade">Estado</label>  
							  <div class="col-md-4">
							   <select v-model="mf.forms.clientes.estado" class="form-control" value="" required="" >
									<option v-for="est in mf.estados" :value="est.Id">{{est.Nome}} - {{est.Uf}}</option>
								</select> 
							  </div>
							</div>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="cidade">Cidade</label>
							  <div class="col-md-4">
							   <select v-model="mf.forms.clientes.cidade"  class="form-control " value="" required="" >
									<option v-for="cidad in mf.cidade | filterBy mf.forms.clientes.estado in 'IdEstado'" v-bind:value="cidad.Id">{{cidad.Nome}}</option>
								</select> 
							  </div>
							</div>

							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="telefone">Telefone</label>  
							  <div class="col-md-4">
							  <input id="telefone" name="telefone" v-model="mf.forms.clientes.telefone" type="text" placeholder="(xx) xxxx - xxxx" class="form-control input-md">
								
							  </div>
							</div>
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="telefone">E-mail</label>  
							  <div class="col-md-4">
							  <input id="email" name="email" v-model="mf.forms.clientes.email" type="text" class="form-control input-md">
								
							  </div>
							</div>
							
							<!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="ie">I.E. / RG</label>  
							  <div class="col-md-4">
							  <input id="ie" name="ie" type="text" v-model="mf.forms.clientes.ie" class="form-control input-md">
								
							  </div>
							  </div>
							  <!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="ie">I. M.</label>  
							  <div class="col-md-4">
							  <input id="im" name="im" type="text" v-model="mf.forms.clientes.im" class="form-control input-md">
								
							  </div>
							  </div>
							    <!-- Text input-->
							    <div class="form-group">
							  <label class="col-md-4 control-label" for="bairro">Bairro</label>  
							  <div class="col-md-4">
							  <input id="bairro" name="bairro" v-model="mf.forms.clientes.bairro" type="text" class="form-control input-md">
								
							  </div>
							  </div>
							    <div class="form-group">
							  <label class="col-md-4 control-label" for="endereco">Endereco</label>  
							  <div class="col-md-4">
							  <input id="endereco" name="endereco" v-model="mf.forms.clientes.endereco" type="text" class="form-control input-md">
								
							  </div>
							  </div>
							
							  <!-- Text input-->
							    <div class="form-group">
							  <label class="col-md-4 control-label" for="numero">Numero</label>  
							  <div class="col-md-4">
							  <input id="numero" name="numero" v-model="mf.forms.clientes.num" type="text" class="form-control input-md">
								
							  </div>
							  </div>
							  <!-- Text input-->
							  
							  <div class="form-group">
							  <label class="col-md-4 control-label" for="cep">CEP</label>  
							  <div class="col-md-4">
							  <input id="cep" name="cep" v-model="mf.forms.clientes.cep" type="text" class="form-control input-md">
								
							  </div>
							  </div>
							  <!-- Text input-->
							<div class="form-group">
							  <label class="col-md-4 control-label" for="status">Status</label>  
							  <div class="col-md-4">
							  <input id="status" name="status" v-model="mf.forms.clientes.status" type="text" placeholder="Ativo" class="form-control input-md">
								
							  </div>
							</div>
							</fieldset>
							</form>

						
						</div>
                        <div class="modal-footer">
                        <div type="button" class="btn btn-primary" onclick="grava_cliente()">Gravar</div> 
                        <div type="button" class="btn btn-default" data-dismiss="modal">Fechar</div></div>
                    </div>
                </div>
            </div>
			<script>
			$(document).ready(function(){
				$("#cnpj_cliente").on("keyup",function(){
					var cnpj = $(this).val().replace(/[^0-9]/gi,"").substr(0,14);
					$(this).val(cnpj)
					if(cnpj.length>=14){
						var url = "consulta_cnpj.php?cnpj="+cnpj;
						$.getJSON(url).done(function(dat){
							console.log(dat)
							if(dat.status == "OK"){
								mf.forms.clientes.status = dat.situacao;
								mf.forms.clientes.cep = dat.cep;
								mf.forms.clientes.num = dat.numero;
								mf.forms.clientes.bairro = dat.bairro;
								mf.forms.clientes.nome = dat.nome;
								mf.forms.clientes.endereco = dat.logradouro;
								mf.forms.clientes.email = dat.email;
								mf.forms.clientes.cidade = dat.municipio;
								mf.forms.clientes.estado = dat.uf;
								mf.forms.clientes.ie = dat.ie;
								mf.forms.clientes.telefone = dat.telefone;
							} else if(dat.status == "ERROR"){
								message(dat.message)
							}
						})
					}
				})
			})
</script>
<!-- CLIENTE FIM -->