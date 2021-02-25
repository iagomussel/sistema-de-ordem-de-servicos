relatorios ={};
vue = {};
carregamento = 9;
tiposutil = false;
system_url = "";
mf = {
	os_s:[],
	orcamentos:[],
	cidade:[],
	formpagtos:[],
	condpagtos:[],
	garantias:[],
	funcionarios:[],
	veiculos:[],
	clientes:[],
	estados:[]
}
mf.forms = {
	os_s:{data:"",cliente:0,veiculo:0,servicos:[{}]},
	orcamentos:{servicos:[{}]},
	clientes:{},
	veiculos:{},
	funcionarios:{},
	formpagtos:{},
	condpagtos:{},
	garantias:{}
}
mf.relatorios = {};
mf.relatorios.forms = {
	visualizar:{data_inicial:"",data_final:"",id:0,local:"",descricao:"",periodo:""},
	faturamento:{data_inicial:"",data_final:"",ordenar_por:'data',graficos:0,tipo_graf:'pie'}
	}
function send(a /*= configurações */){
	def={
		url:system_url+"rule.php",
		method:"get",
		dataType: 'json',
		data:{},
		cache:false,
		
	}
	if(tiposutil){
		carregamento+=1
		$(".carregando_sutil").show();
	}
	$.extend(true, def, a);
	def.complete = function(e){
		if(tiposutil){
			if(carregamento>0) carregamento-=1
			if(carregamento==0){
				$(".carregando_sutil").hide();
			}
		} else{
			if(carregamento>0) carregamento-=1
			if(carregamento==0){
				$(".carregando").hide();
				$(".container").removeClass("fade")
				tiposutil=true;
			}
		}
	}
	$.ajax(def).done(a.complete);
}

novo_os_x_servico = function(){
	mf.forms.os_s.servicos.push({quantidade:1,servico:"",valorunit:0})
}
remove_os_x_servico = function(a){
	mf.forms.os_s.servicos.$remove(mf.forms.os_s.servicos[a]);
}

novo_orcamento_x_servico = function(){
	mf.forms.orcamentos.servicos.push({quantidade:1,servico:"",valorunit:0})
}
remove_orcamento_x_servico = function(a){
	mf.forms.orcamentos.servicos.$remove(mf.forms.orcamentos.servicos[a]);
}
$(document).ready(function() {

  //carregando dados
  
  save({
	  local:"os_s",
	  callback:function(a){
			mf.os_s=a.data
	  }
  })
  save({
	  local:"orcamentos",
	  callback:function(a){
			mf.orcamentos = a.data
	  }
  })
    save({
	  local:"clientes",
	  callback:function(a){
		  mf.clientes = a.data;
	  }
  })
    save({
	  local:"funcionarios",
	  callback:function(a){
		 mf.funcionarios = a.data;
	  }
  })
    save({
	  local:"veiculos",
	  callback:function(a){
		  mf.veiculos = a.data;
	  }
  })
      save({
	  local:"garantias",
	  callback:function(a){
		  mf.garantias = a.data;
	  }
  })
	  save({
	  local:"formpagtos",
	  callback:function(a){
		  mf.formpagtos = a.data;
	  }
  })
  save({
	  local:"condpagtos",
	  callback:function(a){
		  mf.condpagtos = a.data;
	  }
  })
  save({
	  local:"cidade",
	  callback:function(a){
		  mf.cidade = a.data;
	  }
  })
  save({
	  local:"estados",
	  callback:function(a){
		  mf.estados = a.data;
	  }
  })
     $('#os_s_lst').on('click', 'tbody tr', function() {
		$('#os_s_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");
	});
	  $('#orcamento_lst').on('click', 'tbody tr', function() {
		$('#orcamento_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");
	});
    $('#clientes_lst').on('click', 'tbody tr', function() {
		$('#clientes_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");
	});
    $('#veiculos_lst').on('click', 'tbody tr', function() {
		$('#veiculos_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");	 
	});
    $('#funcionarios_lst').on('click', 'tbody tr', function() {
		$('#funcionarios_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");	 
	});
    $('#condpagto_lst').on('click', 'tbody tr', function() {
		$('#condpagto_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");
	})
	$('#formpagto_lst').on('click', 'tbody tr', function() {
		$('#formpagto_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");
	})
    $('#garantias_lst').on('click', 'tbody tr', function() {
		$('#garantias_lst').find("tbody tr").removeClass("selected");
		$(this).addClass("selected");		
	});
  /*-- criando eventos --*/

  $(document).keyup(function(){
			var l= 0
			for(var a in mf.forms.os_s.servicos){
				l+=parseFloat(mf.forms.os_s.servicos[a].quantidade) *parseFloat( mf.forms.os_s.servicos[a].valorunit) ;
			};	
			mf.forms.os_s.valor=l
			/*l=0
			for(var a in mf.forms.orcamentos.servicos){
				l+=mf.forms.orcamentos.servicos[a].quantidade * mf.forms.orcamentos.servicos[a].valorunit ;
			};
			mf.forms.orcamentos.valor=l;*/
	})
	$("[mask]").keyup(function (evt) {
			var padrao = $(this).attr("mask");
           //testa a tecla pressionada pelo usuario  
           var charCode = (evt.which) ? evt.which : evt.keyCode;  
           if (charCode == 8) return true; //tecla backspace permitida
           $(this).attr("maxLength", padrao.length); //Define dinamicamente o tamanho maximo do campo de acordo com o padrao fornecido  
           //aplica a mascara de acordo com o padrao fornecido  
           entrada = $(this).val();
           if (padrao.length > entrada.length && padrao.charAt(entrada.length) != '#') {  
                $(this).val( entrada + padrao.charAt(entrada.length));                 
           }		   
           return true;  
      } ) 
    /*Enter como TAB*/
	$(document).keydown(function(e) {
        var self = $(':focus'),
            // Set the form by the current item in focus
            form = self.parents('form:eq(0)'),
            focusable;
        focusable = form.find('input,a,select,button,textarea,div.btn.primary,div[contenteditable=true]').filter(':visible');
		var charCode = (e.which) ? e.which : e.keyCode; 
        function enterKey() {
            if (charCode === 13 && !self.is('textarea,div[contenteditable=true]')) {
                if ($.inArray(self, focusable) && (!self.is('a,button,div.btn.primary'))) {
                    e.preventDefault();
                }
                focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();
                
				return false;
            }
        }
        enterKey();
    });
	/*cancelar submit form*/
	$('form').on('submit', function() {
        return false
    })
	/* pesquisa em tabelas*/
  $(".search").keyup(function() {
    target_id = $(this).attr("target")
    if (target_id == "") {
      return false
    }
    // When value of the input is not blank
    if ('' != this.value) {
      var reg = new RegExp(this.value, 'i'); // case-insesitive
      $(target_id + ' tbody').find('tr').each(function() {
        var $me = $(this);
        if (!$me.children('td').text().match(reg)) {
          $me.hide();
        } else {
          $me.show();
        }
      });
    } else {
      $(target_id + ' tbody').find('tr').show();
    }
  })
  $('[data-provide=datepicker]').datepicker({ language:"pt-BR",todayHighlight:true})
  $(".nova_os_form").click(function(){
	vue.$set("mf.forms.os_s",{data:"",cliente:0,veiculo:0,servicos:[]});
	mf.forms.os_s.servicos.push({quantidade:1,servico:"",valorunit:0})
	$("#form_os_s_modal").modal("show");
	})
   $(".novo_orcamento_form").click(function(){
		vue.$set("mf.forms.orcamentos",{data:"",cliente:0,veiculo:0,servicos:[]});
		mf.forms.orcamentos.servicos.push({quantidade:1,servico:"",valorunit:0})
		$("#form_orcamento_modal").modal("show");
	})
	$(".novo_cliente_form").click(function(){
		mf.forms.clientes = {nome:"",cidade:4204,estado:19,telefone:"",cnpj:"",num:0,bairro:"",ie:"",status:"",im:"",email:"",endereco:"",cep:""};
		$("#form_clientes_modal").modal("show");
	})
	$(".novo_veiculos_form").click(function(){
		mf.forms.veiculos = {placa:"",modelo:"",ano:"",fabricante:""};
		$("#form_veiculos_modal").modal("show");
	})
	$(".novo_funcionarios_form").click(function(){
		mf.forms.funcionarios = {nome:"",telefone1:"",telefone2:"",telefone3:""};
		
		$("#form_funcionarios_modal").modal("show");
	})
	$(".novo_formpagto_form").click(function(){
		mf.forms.formpagtos = {descricao:""};
		
		$("#form_formpagto_modal").modal("show");
	})
	$(".novo_condpagto_form").click(function(){
		mf.forms.condpagtos = {descricao:""};
		$("#form_condpagto_modal").modal("show");
	})
	$(".novo_garantia_form").click(function(){
		mf.forms.garantias= {descricao:""};
		$("#form_garantias_modal").modal("show");
	})
	//DATA BINDING
	vue = new Vue({
	  el: '#container',
	  data:{mf: mf}
	})
});


alterar_os_ = function(){
	ind = $('#os_s_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"os_s",
		acao:"get_all",
		dados:{id:mf.os_s[ind].id},
		callback:function(a){
			if(a.data[0]!=undefined){
				vue.$set("mf.forms.os_s",a.data[0])
			}
			$("#form_os_s_modal").modal("show")
		}
	})
	
}
alterar_orcamento = function(){
	ind = $('#orcamento_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"orcamentos",
		acao:"get_all",
		dados:{id:mf.orcamentos[ind].id},
		callback:function(a){
			if(a.data[0]!=undefined){
				vue.$set("mf.forms.orcamentos",a.data[0])
			}
			$("#form_orcamento_modal").modal("show")
		}
	})
	
}
alterar_cliente = function(){
	ind = $('#clientes_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"clientes",
		acao:"get_all",	
		dados:{id:mf.clientes[ind].id},
		callback:function(a){
			if(a.data.length){mf.forms.clientes = a.data[0]}
			$("#form_clientes_modal").modal("show")
		}
	})
	
}
alterar_veiculo = function(){
	ind = $('#veiculos_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"veiculos",
		acao:"get_all",
		dados:{id:mf.veiculos[ind].id},
		callback:function(a){
			if(a.data.length){mf.forms.veiculos = a.data[0]}
			$("#form_veiculos_modal").modal("show")
		}
	})
}
alterar_funcionario = function(){
	ind = $('#funcionarios_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"funcionarios",
		acao:"get_all",
		dados:{id:mf.funcionarios[ind].id},
		callback:function(a){
			if(a.data.length){mf.forms.funcionarios = a.data[0]}
			$("#form_funcionarios_modal").modal("show")
		}
	})
}
alterar_formpagto = function(){
	ind = $('#formpagto_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"formpagtos",
		acao:"get_all",
		dados:{id:mf.formpagtos[ind].id},
		callback:function(a){
			if(a.data.length){mf.forms.formpagtos = a.data[0]}
			$("#form_formpagto_modal").modal("show")
		}
	})
}
alterar_condpagto = function(){
	ind = $('#condpagto_lst').find(".selected").attr("ind")
	console.log(ind);
	if(ind==undefined)return false;
	save({
		local:"condpagtos",
		acao:"get_all",
		dados:{id:mf.condpagtos[ind].id},
		callback:function(a){
			console.log(a.data);
			if(a.data.length){mf.forms.condpagtos = a.data[0]}
			$("#form_condpagto_modal").modal("show")
		}
	})
}
alterar_garantias = function(){
	ind = $('#garantias_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"garantias",
		acao:"get_all",
		dados:{id:mf.garantias[ind].id},
		callback:function(a){
			if(a.data.length){mf.forms.garantias = a.data[0]}
			$("#form_garantias_modal").modal("show")
		}
	})
}
grava_os_ = function(){
	os=mf.forms.os_s;
	if(!os.cliente) {message("Cliente não pode ficar vazio","Preencha");return false;}
	if(!os.veiculo) {message("Veiculo não pode ficar vazio","Preencha");return false;}
	if(!os.funcionario) {message("Funcionario não pode ficar vazio","Preencha");return false;}
	if(!os.garantia) {message("Garantia não pode ficar vazio","Preencha");return false;}
	if(!os.formpagto) {message("Forma de pagamento não pode ficar vazio","Preencha");return false;}
	if(!os.condpagto) {message("Condição de pagamento não pode ficar vazio","Preencha");return false;}
	if(os.id==undefined) acao="add"; else acao="edit";
	save({
		local:"os_s",
		acao:acao,
		dados:os,
		callback:function(a){
			
			if(a.error){
				message(a,"error")
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					dat.cliente = mf.clientes[mf.clientes.indexOfOb("id",""+dat.cliente)].nome
					dat.veiculo = mf.veiculos[mf.veiculos.indexOfOb("id",""+dat.veiculo)].placa
					dat.funcionario = mf.funcionarios[mf.funcionarios.indexOfOb("id",""+dat.funcionario)].nome
					dat.garantia = mf.garantias[mf.garantias.indexOfOb("id",""+dat.garantia)].descricao
					mf.os_s.push(dat);
					vue.$set("mf.forms.os_s",{nome:"",cidade:4204,estado:19,telefone:"",cnpj:"",num:0,bairro:"",ie:"",status:"",im:"",email:"",endereco:"",cep:""});
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					dat.cliente = mf.clientes[mf.clientes.indexOfOb("id",""+dat.cliente)].nome
					dat.veiculo = mf.veiculos[mf.veiculos.indexOfOb("id",""+dat.veiculo)].placa
					dat.funcionario = mf.funcionarios[mf.funcionarios.indexOfOb("id",""+dat.funcionario)].nome
					dat.garantia = mf.garantias[mf.garantias.indexOfOb("id",""+dat.garantia)].descricao
					vue.$set('mf.os_s['+mf.os_s.indexOfOb("id",""+dat.id)+']',dat)
					vue.$set("mf.forms.os_s",{nome:"",cidade:4204,estado:19,telefone:"",cnpj:"",num:0,bairro:"",ie:"",status:"",im:"",email:"",endereco:"",cep:""});
				} 
				$("#form_os_s_modal").modal("hide");
			}
		}
	})
}
grava_orcamento = function(){
	var ors=mf.forms.orcamentos;
	if(!ors.cliente) {message("Cliente não pode ficar vazio","Preencha");return false;}
	if(!ors.veiculo) {message("Veiculo não pode ficar vazio","Preencha");return false;}
	if(!ors.funcionario) {message("Funcionario não pode ficar vazio","Preencha");return false;}
	if(!ors.garantia) {message("Garantia não pode ficar vazio","Preencha");return false;}
	if(!ors.formpagto) {message("Forma de pagamento não pode ficar vazio","Preencha");return false;}
	if(!ors.condpagto) {message("Condição de pagamento não pode ficar vazio","Preencha");return false;}
	if(ors.id==undefined) acao="add"; else acao="edit";
	save({
		local:"orcamentos",
		acao:acao,
		dados:ors,
		callback:function(a){
			
			if(a.error){
				message(a,"error")
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					dat.cliente = mf.clientes[mf.clientes.indexOfOb("id",""+dat.cliente)].nome
					dat.veiculo = mf.veiculos[mf.veiculos.indexOfOb("id",""+dat.veiculo)].placa
					dat.funcionario = mf.funcionarios[mf.funcionarios.indexOfOb("id",""+dat.funcionario)].nome
					dat.garantia = mf.garantias[mf.garantias.indexOfOb("id",""+dat.garantia)].descricao
					mf.orcamentos.push(dat);
					vue.$set("mf.forms.orcamentos",{nome:"",cidade:4204,estado:19,telefone:"",cnpj:"",num:0,bairro:"",ie:"",status:"",im:"",email:"",endereco:"",cep:""});
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					dat.cliente = mf.clientes[mf.clientes.indexOfOb("id",""+dat.cliente)].nome
					dat.veiculo = mf.veiculos[mf.veiculos.indexOfOb("id",""+dat.veiculo)].placa
					dat.funcionario = mf.funcionarios[mf.funcionarios.indexOfOb("id",""+dat.funcionario)].nome
					dat.garantia = mf.garantias[mf.garantias.indexOfOb("id",""+dat.garantia)].descricao
					vue.$set("mf.orcamentos["+mf.orcamentos.indexOfOb("id",""+dat.id)+"]",dat);
					vue.$set("mf.forms.orcamentos",{nome:"",cidade:4204,estado:19,telefone:"",cnpj:"",num:0,bairro:"",ie:"",status:"",im:"",email:"",endereco:"",cep:""});
				} 
				$("#form_orcamento_modal").modal("hide");
			}
		}
	})
}
grava_cliente = function(){
	var d = mf.forms.clientes;
	if(d.id==undefined)acao = "add"; else acao="edit";

	save({
		local:"clientes",
		dados:d,
		acao:acao,
		ind: mf.forms.clientes_ind,
		callback:function(a){
			
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					dat.cidade = mf.cidade[mf.cidade.indexOfOb("Id",""+dat.cidade)].Nome
					dat.estado = mf.estados[mf.estados.indexOfOb("Id",""+dat.estado)].Uf
					mf.clientes.push(dat);
					mf.forms.clientes = {nome:"",cidade:4204,estado:19,telefone:"",cnpj:"",num:0,bairro:"",ie:"",status:"",im:"",email:"",endereco:"",cep:""};
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					dat.cidade = mf.cidade[mf.cidade.indexOfOb("Id",""+dat.cidade)].Nome
					dat.estado = mf.estados[mf.estados.indexOfOb("Id",""+dat.estado)].Uf
					vue.$set('mf.clientes['+mf.clientes.indexOfOb("id",""+dat.id)+']',dat)
				} 
				$("#form_clientes_modal").modal("hide");
			}
		}
	})
	
}
grava_veiculo = function(){
	var d = mf.forms.veiculos;
	if(d.id==undefined)acao = "add"; else acao="edit";

	save({
		local:"veiculos",
		dados:d,
		acao:acao,
		callback:function(a){
			
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					dat.clienteNome = mf.clientes[mf.clientes.indexOfOb("id",""+dat.cliente)].nome
					mf.veiculos.push(dat);
					mf.forms.veiculos = {placa:"",modelo:"",ano:"",fabricante:"",cliente:0};
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					dat.clienteNome = mf.clientes[mf.clientes.indexOfOb("id",""+dat.cliente)].nome
					vue.$set('mf.veiculos['+mf.veiculos.indexOfOb("id",dat.id)+']',dat)
				} 
				$("#form_veiculos_modal").modal("hide");
			}
		}
	})
	
}
grava_funcionario = function(){
	var d = mf.forms.funcionarios;
	if(d.id==undefined)acao = "add"; else acao="edit";

	save({
		local:"funcionarios",
		dados:d,
		acao:acao,
		callback:function(a){
			
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					mf.funcionarios.push(dat);
					mf.forms.funcionarios = {nome:"",telefone1:"",telefone2:"",telefone3:""};
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					vue.$set('mf.funcionarios['+mf.funcionarios.indexOfOb("id",""+dat.id)+']',dat)
				} 
				$("#form_funcionarios_modal").modal("hide");
			}
		}
	})
}
grava_formpagto = function(){
	var d = mf.forms.formpagtos;
	if(d.id==undefined)acao = "add"; else acao="edit";

	save({
		local:"formpagtos",
		dados:d,
		acao:acao,
		callback:function(a){
			
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					mf.formpagtos.push(dat);
					mf.forms.formpagtos = {descricao:""};
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					vue.$set('mf.formpagtos['+mf.formpagtos.indexOfOb("id",""+dat.id)+']',dat)
				} 
				$("#form_formpagto_modal").modal("hide");
			}
		}
	})
}
grava_condpagto = function(){
	var d = mf.forms.condpagtos;
	if(d.id==undefined)acao = "add"; else acao="edit";
	if(!d.formpagto){message("Forma de Pagto. não pode ficar em branco!","campo faltando");return false;}
	if(!d.descricao){message("Descricao. não pode ficar em branco!","campo faltando");return false;}
	save({
		local:"condpagtos",
		dados:d,
		acao:acao,
		callback:function(a){
			
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					dat.formpagto_descricao = mf.formpagtos[mf.formpagtos.indexOfOb("id",dat.formpagto)].descricao;
					mf.condpagtos.push(dat);
					mf.forms.condpagtos = {descricao:""};
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					dat.formpagto_descricao = mf.formpagtos[mf.formpagtos.indexOfOb("id",dat.formpagto)].descricao;
					vue.$set('mf.condpagtos['+mf.condpagtos.indexOfOb("id",dat.id)+']',dat)
				} 
				$("#form_condpagto_modal").modal("hide");
			}
		}
	})
}
grava_garantia = function(){
	var d = mf.forms.garantias;
	if(d.id==undefined)acao = "add"; else acao="edit";

	save({
		local:"garantias",
		dados:d,
		acao:acao,
		callback:function(a){
			
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='add'){
					var dat = a.data;
					mf.garantias.push(dat);
					mf.forms.garantias = {descricao:""};
				} else if(a.request.acao=='edit'){
					var dat = a.data;
					vue.$set('mf.garantias['+mf.garantias.indexOfOb("id",dat.id)+']',dat)
				} 
				$("#form_garantias_modal").modal("hide");
			}
		}
	})
}
remove_os = function(){
	ind = $('#os_s_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"os_s",
		dados:{id:mf.os_s[ind].id},
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					mf.os_s.$remove(mf.os_s[mf.os_s.indexOfOb("id",""+a.data.id)]);
					message("Removido","Sucesso");
				}
			}
		}
	})
}
remove_orcamento = function(){
	ind = $('#orcamento_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"orcamentos",
		dados:{id:mf.orcamentos[ind].id},
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					mf.orcamentos.$remove(mf.orcamentos[mf.orcamentos.indexOfOb("id",""+a.data.id)]);
					message("Removido","Sucesso");
				}
			}
		}
	})
}
remove_cliente = function(){
	ind = $('#clientes_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"clientes",
		dados:{id:mf.clientes[ind].id},
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					mf.clientes.$remove(mf.clientes[mf.clientes.indexOfOb("id",""+a.data.id)]);
					message("Removido","Sucesso");
				}
			}
		}
	})
}
remove_veiculo = function(){
	ind = $('#veiculos_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"veiculos",
		dados:{id:mf.veiculos[ind].id},
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					mf.veiculos.$remove(mf.veiculos[mf.veiculos.indexOfOb("id",""+a.data.id)]);
					message("removido","danger")
				}
			}
		}
	})
}
remove_funcionario = function(){
	ind = $('#funcionarios_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"funcionarios",
		dados:{id:mf.funcionarios[ind].id},
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					mf.funcionarios.$remove(mf.funcionarios[mf.funcionarios.indexOfOb("id",""+a.data.id)]);
					message("removido","danger")
				}
			}
		}
	})
}
remove_formpagto = function(){
	ind = $('#formpagto_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	var d = {id:mf.formpagtos[ind].id};
	save({
		local:"formpagtos",
		dados:{id:mf.formpagtos[ind].id},
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					console.log(a.data);
					mf.formpagtos.$remove(mf.formpagtos[mf.formpagtos.indexOfOb("id",""+a.data.id)]);
					message("removido","success")
				}
			}
		}
	})
}
remove_condpagto = function(){
	ind = $('#condpagto_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	var d = {id:mf.condpagtos[ind].id};
	save({
		local:"condpagtos",
		dados:d,
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					console.log(a.data);
					mf.condpagtos.$remove(mf.condpagtos[mf.condpagtos.indexOfOb("id",""+a.data.id)]);
					message("removido","success")
				}
			}
		}
	})
}
remove_garantia = function(){
	ind = $('#garantias_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"garantias",
		dados:{id:mf.garantias[ind].id},
		acao:"remove",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='remove'){
					mf.garantias.$remove(mf.garantias[mf.garantias.indexOfOb("id",""+a.data.id)]);
					message("removido","success")
				}
			}
		}
	})
}
/*Envia os dados para gravar no servidor*/
save = function(options){
	if(options.local===undefined) return false;
	if(options.callback===undefined) callback = function(e){}; else	callback = options.callback;
	
		_data = {
			acao:options.acao,
			local:options.local
			}
			if(!(options.dados==undefined)){
				_dados = Base64.encode(JSON.stringify(options.dados))
				_data["dados"] = _dados;
			}
	send({
		data:_data,
		success:callback}
	)	
}
message = function(a,cla){
	 BootstrapDialog.alert({
            title: cla,
            message: a
        });
}
//relatorios
mf.relatorios.faturamento = function(){
	mf.relatorios.forms.faturamento.data_inicial = "";
	mf.relatorios.forms.faturamento.data_final = "";
	mf.relatorios.forms.faturamento.ordenar_por = "data";
	mf.relatorios.forms.faturamento.graficos = "0";
	mf.relatorios.forms.faturamento.tipo_graf = "pie";
	$("#form_faturamento_modal").modal("show");
}
mf.relatorios.visualizar = function(local,ind_get){
	ind = $(ind_get).find(".selected").attr("ind")
	console.log($(ind_get));
	if(ind==undefined) return false;
	mf.relatorios.forms.visualizar.local = local;
	mf.relatorios.forms.visualizar.periodo = true;
	switch(local){
		case "clientes":
			mf.relatorios.forms.visualizar.descricao = "Cliente "+mf.clientes[ind].nome
			mf.relatorios.forms.visualizar.id = mf.clientes[ind].id
		break;
		case "veiculos":
			mf.relatorios.forms.visualizar.descricao =  "Veiculo, Placa: "+mf.veiculos[ind].placa
			mf.relatorios.forms.visualizar.id = mf.veiculos[ind].id
		break;
		case "funcionarios":
			mf.relatorios.forms.visualizar.descricao =  "Funcionario "+mf.funcionarios[ind].nome
			mf.relatorios.forms.visualizar.id = mf.funcionarios[ind].id
		break;
		case "os_s":
			mf.relatorios.forms.visualizar.descricao = "Ordem de servico"
			mf.relatorios.forms.visualizar.id = mf.os_s[ind].id
			mf.relatorios.forms.visualizar.periodo = false;
		break;
		case "orcamentos":
			mf.relatorios.forms.visualizar.descricao = "Orcamento"
			mf.relatorios.forms.visualizar.id = mf.orcamentos[ind].id
			mf.relatorios.forms.visualizar.periodo = false;
		break;
	}
	mf.relatorios.forms.visualizar.data_inicial="";
	mf.relatorios.forms.visualizar.data_final="";
	$("#relatorios_visualizar").modal("show");
}
autorizar_orcamento = function(){
	ind = $('#orcamento_lst').find(".selected").attr("ind")
	if(ind==undefined)return false;
	save({
		local:"orcamentos",
		dados:{id:mf.orcamentos[ind].id},
		acao:"autorizar",
		callback:function(a){
			if(a.error){
				message(a.error,"Erro");
			} else {
				if(a.request.acao=='autorizar'){
					console.log(a)
					mf.os_s.push(mf.orcamentos[mf.orcamentos.indexOfOb("id",""+a.data.id)]);
					mf.orcamentos.$remove(mf.orcamentos[mf.orcamentos.indexOfOb("id",""+a.data.id)]);
					$('.nav-tabs a[href="#os_s"]').tab('show')
				}
			}
		}
	})
}