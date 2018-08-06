			
			<ul class="nav nav-tabs">
							<li class="active"><a href="#cad_form_cliente" data-toggle="tab">Gerais</a></li>
							<li><a href="#equi_form_cliente" data-toggle="tab">Equipamentos</a></li>
						</ul>
					
						<form id="form_clientes" class="row">
						<input type="hidden" name="id" /><!--input obrigatório -->
						<div class="tab-content">
		<div id="cad_form_cliente" class="tab-pane fade in active">			
							<fieldset>
							<!-- Text input-->
							<div class="col-md-4">
							  <label class="control-label" for="cnpj">CNPJ</label>  
							  <div class="">
							  <input id="cnpj_cliente" name="cnpj" type="text" placeholder="00.000.000/0000-000" class="form-control input-md cnpj_cliente">
								
							  </div>
							</div>
							
							<!-- Text input-->
							<div class="col-md-8">
							  <label class=" control-label" for="nome">Nome</label>  
							  
							  <input id="nome" name="nome" type="text" v-model="mf.forms.clientes.nome" placeholder="Nome" class="form-control input-md" required="">
								
							  
							</div>
							
							
							  <div class="col-md-4">
							  <label class="control-label" for="cep">CEP</label>  
							  <div class="">
							  <input id="cep" name="cep" type="text" class="form-control input-md">
								
							  </div>
							  </div>
							
							<div class="col-md-4">
							  <label class="control-label" for="cidade">Cidade / Estado</label>
							  <div class="">
							   <select name="cidade" id="cidade" url="<?php echo Qr::inst("cidade")->table();?>" class="select2" data-table="cidades" text="{{Nome}} - {{UF}}"  value="" required="" >
								</select>
							  </div>
							</div>

							<div class="col-md-4">
							  <label class=" control-label" for="bairro">Bairro</label>  
							  <div class="">
								<input id="bairro" name="bairro" type="text" class="form-control input-md">
							  </div>
						    </div>
							
							<div class="col-md-8">
							  <label class=" control-label" for="endereco">Endereco</label>  
							  <div class="">
							  <input id="endereco" name="endereco" v-model="mf.forms.clientes.endereco" type="text" class="form-control input-md">
								
							  </div>
							  </div>
							 
							    <div class="col-md-2">
							  <label class="control-label" for="num">Numero</label>  
							  <div class="">
							  <input id="num" name="num"  type="text" class="form-control input-md">
								
							  </div>
							  </div>
								<div class="col-md-2">
							  <label class="control-label" for="numero">Complemento</label>  
							  <div class="">
							  <input id="complemento" name="complemento"  type="text" class="form-control input-md">
								
							  </div>
							  </div>


							  <!-- Text input-->
							<div class="col-md-4">
							  <label class="control-label" for="telefone">Telefone</label>  
							  <div class="">
							  <input id="telefone" name="telefone" type="text" placeholder="(xx) xxxx - xxxx" class="form-control input-md">
								
							  </div>
							</div>
							<!-- Text input-->
							<div class="col-md-8">
							  <label class="control-label" for="telefone">E-mail</label>  
							  <div class="">
							  <input id="email" name="email"  type="text" class="form-control input-md">
								
							  </div>
							</div>
							
							<!-- Text input-->
							<div class="col-md-4">
							  <label class=" control-label" for="ie">I.E.</label>  
							  <div class="">
							  <input id="ie" name="ie" type="text"  class="form-control input-md">
								
							  </div>
							  </div>
							  
							  <!-- Text input-->
							<div class="col-md-4">
							  <label class="control-label" for="ie">I. M.</label>  
							  <div class="">
							  <input id="im" name="im" type="text" class="form-control input-md">
								
							  </div>
							  </div>
							  
							  <!-- Text input-->
							<div class="col-md-4">
							  <label class="control-label" for="ie">SUFRAMA</label>  
							  <div class="">
							  <input id="suframa" name="suframa" type="text" v-model="mf.forms.clientes.im" class="form-control input-md">
								
							  </div>
							  </div>
							    
							<div class="col-md-4">
							  <label class=" control-label" for="blk"><input name="blk" type="checkbox" >
							   Bloqueado?</label>  
							  <label class=" control-label" for="motivo">Motivo</label>  
							  <div class="">
							  <input id="text" name="motivo" v-model="mf.forms.clientes.status" type="text" placeholder="Ativo" class="form-control input-md">
							  </div>
							
							</div>
							
							  <!-- Text input-->
							<div class=" col-md-4">
							  <label class=" control-label" for="status">Status</label>  
							  <div class="">
							  <input id="status" name="status" type="text" placeholder="Ativo" class="form-control input-md">
								
							  </div>
							</div>
							<div class=" col-md-12">
							  <label class=" control-label" for="status">Observações</label>  
							  <div class="">
								<textarea></textarea>
								
							  </div>
							</div>
							
								
						</fieldset>
</div>
					<div id="equi_form_cliente" class="tab-pane fade">
					<table class="table table-with-form">
	
					<thead><tr>
						<th>Placa</th>
						<th>Modelo</th>
						<th>Cor</th>
						<th>Ano</th>
						</tr></thead>
						<tbody>
						<tr>
							<td><input></td>
							<td><input></td>
							<td><input></td>
							<td><input></td>
						</tr>
						</tbody>
					</table>
					</div>
					
					</form>
						</div>	
							
			<script>
			
			$(document).ready(function(){
				var table = $("#form_clientes")
				table.find(".cnpj_cliente").on("keyup",function(){
					var cnpj = $(this).val().replace(/[^0-9]/gi,"").substr(0,14);
					$(this).val(cnpj)
					if(cnpj.length>=14)
					{
						var url = "consulta_cnpj.php?cnpj="+cnpj;
						$.getJSON(url).done(function(dat){
							console.log(dat);
							if(dat.status == "OK"){
								
								table.find("[name=status]").val(dat.situacao);
								table.find("[name=cep]").val(dat.cep);
								table.find("[name=numero]").val(dat.numero);
								table.find("[name=complemento]").val(dat.complemento);
								table.find("[name=bairro]").val(dat.bairro);
								table.find("[name=nome]").val(dat.nome);
								table.find("[name=endereco]").val(dat.logradouro);
								table.find("[name=email]").val(dat.email);
								table.find("[name=cidade]").val(dat.municipio);
								table.find("[name=estado]").val(dat.uf);
								table.find("[name=ie]").val(dat.ie);
								table.find("[name=telefone]").val(dat.telefone);
							} else if(dat.status == "ERROR"){
								message(dat.message)
							}
						})
					}
				})
			})
</script>
<!-- CLIENTE FIM -->

