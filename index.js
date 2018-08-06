tabList=[]
function voltar_tab(){
	if(tabList.length>1){
			tabList.pop()
			var a = $("<a/>").attr("href",tabList[tabList.length-1]).attr("data-toggle","tab")
			a.tab("show");
		}
}
$(document).ready(function() {
//remove a classe active no menu para evitar duplo active
	$(".nav li").click(function() {
		$(".nav li").removeClass('active');  
	});

//fornesce uma mascara em text input
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
		search($(this).attr("target"),1,true);
  })
  
  /*registra o caminho dos modals*/
  $('[data-toggle=tab]').on('show.bs.tab', gravar_tab);
	
	$(".return_tab").click(voltar_tab)
    
	$('.table_list').on('click', 'tr', function(e) {
		
		if($(this).hasClass("selected")&&(!e.shiftKey)){
			$(this).removeClass("selected");
			return;
		}
		
		
		if(e.shiftKey){
			var frs = $(this).parent().find("tr.selected");
			$(this).parent().find("tr").removeClass("selected");
			var ind = (frs.length>0)?frs.first().index():$(this).parent().find("tr").first().index();
			thisind = $(this).index()
			var interator = (ind<thisind)?1:-1;
			while(ind!=thisind){
				$(this).parent().children().eq(ind).addClass("selected");
				ind+=interator;
			}
			$(this).addClass("selected");
			return;
		}
		
		if(!(e.ctrlKey||e.shiftKey)){
			$(this).parent().find("tr").removeClass("selected");
		}
		
		$(this).addClass("selected");
				
	});
	
	/*COMPONENTE table-with-form */
	$(".table-with-form-close").on("click",function(){
		if($(this).parent().parent().children().length>1)
			$(this).parent().remove();
	})
	$(".table-with-form-add").on("click",function(){
		var table = $(this).parent().find(".table-with-form");
		var nrow = table.find("tbody tr").first().clone();
		nrow.find("input").val("")
		nrow.find(".table-with-form-close").on("click",function(){
			if($(this).parent().parent().children().length>1)
				$(this).parent().remove();
		})
		
		table.find("tbody").append(nrow)
	})
	
	/*impedir seleção quando arrastar o mouse*/
	document.onselectstart = function (){return false}
	
	/* criar select2 dinamicamente */

	$(".select2").each(function(i,val){
		
			var text_name_def = $(val).attr("text")
			var filter = $(val).attr("filter");
			var opt = {
				theme: "bootstrap",
				placeholder: "Buscar",
				ajax:{
					url:"ajax.php",
					dataType: 'json',
					
					data: function (params) {
						var query = {
							local: $(val).attr("url"),
							acao: "search",
							term: params.term,
							page: params.page
						}
						if((filter !== undefined)&&(filter.length>0)){
							query.filter = eval(filter)
						}
						return query;
					},
					processResults: function (data) {
					  // Tranforms the top-level key of the response object from 'items' to 'results'
						var ret = [];
						
						for(var a=0;a<data.data.length;a++){
							text_name = text_name_def
							for(b in data.data[a]){
								text_name = text_name.replace("{{"+b+"}}",data.data[a][b])
							}
							ret.push({
								id:data.data[a]["id"],
								text:text_name
							})
						}
						return {
							results: ret,
							pagination:{
								more:(data.paginacao.atual<data.paginacao.ultima)
							}
						};
					}
					
				}
			}
			
			
			$(val).select2(opt);
			
	})
}
 ) 
  function paginate(a,b,paginat=true){
		var pagens = $("#"+a+" .pagination_div")		  
			
		  if (pagens.data) pagens.twbsPagination('destroy');
			pagens.twbsPagination({
				totalPages: b["ultima"],
				startPage: b["atual"],
				visiblePages: 5,
				onPageClick: function (evt, page) {
					search(a,page,false)
				}
			});
		  
	}
function search(id_base,page=1,paginat=false){
	
	var search = $("#"+id_base+" .search")
	var url_ajax =search.attr("url")
	var term = search.val();
	if (url_ajax == "") {
	  return false
    }
	//desfaz a paginação
	
      //faz a consulta ajax
	  $.ajax({
		url:"ajax.php?local="+url_ajax+"&acao=search&term="+term+"&id_base="+id_base+"&page="+page,
		method:"get",
		dataType: 'json',
		cache:false,
		}).done(function(a){
			//poe os dados na tabelas/
			var id_base = a["request"]["id_base"]
			var list = $("#"+id_base+" .table_list");
			if(!a["data"].length){
				list.html("<tr><td>Nenhum registro encontrado</td></tr>")
				
			} else {
				draw_table(list,a["data"])
				//atualiza o paginador
				if(paginat)paginate(id_base,a["paginacao"]);
			}
		})
} 
  
  function draw_table(targ,list){
			targ.html("")
			for (s in list) {
				var row = $("<tr />");
				row.attr("code",list[s]["id"]);
				for(t in list[s]){
					var col = $("<td />");
					col.text(list[s][t]);
					row.append(col);
				}
				targ.append(row)
			}

  }
message = function(a,cla){
	 BootstrapDialog.alert({
            title: cla,
            message: a
        });
}

function novo_registro(table,callback=function(){}){
	form =$("#"+table+"_form form")
	clean_form(form);
	$("#"+table+"_form .gravar_btn")
		.unbind("click")
		.on("click",function(){gravar_registro(table,callback)})
	
	$("<a/>")
		.attr("data-toggle","tab")
		.attr("href","#"+table+"_form")
		.on('show.bs.tab', gravar_tab)
		.tab("show");
}

function alterar_registro(table){
	regs= $("#"+table+" tr.selected")
	if(regs.length <= 0){
		message("è nescessario selecionar um registro")
		return false;
	}
	if(regs.length > 1){
		message("Selecione apenas um registro para ésta operação")
		return false;
	}
	var dados = {id: regs.attr("code")};
	if(dados.id===undefined){
		return message("erro inesperado");
	}
	$.ajax({
		url:"Ajax.php",
		data:{
			local:$("#"+table+"_form").attr("url"),
			acao:"get",
			dados:Base64.encode(JSON.stringify(dados))
			}
	}).done(function(a){
		if(a.error){
			message(a.error)
			} else {
			form =$("#"+table+"_form form")
			clean_form(form,a["data"][0]);
			console.log(a["data"][0]);
			$("#"+table+"_form .gravar_btn")
				.unbind("click")
				.on("click",function(){gravar_registro(table)})
			
			//abre a tab
			$("<a/>")
				.attr("data-toggle","tab")
				.attr("href","#"+table+"_form")
				.on('show.bs.tab', gravar_tab)
				.tab("show");
		}
	})
	
}

function imprimir_registro(table){
	regs= $("#"+table+" tr.selected")
	console.log(regs);
	if(regs.length <= 0){
		message("è nescessario selecionar pelo menos um registro")
		return false;
	}		
	
}
function excluir_registro(table){
	var regs_id = []
	$("#"+table+" tr.selected").each(function(i,v){
		regs_id.push($(v).attr("code"));
	})

}

function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback) {
       
	   
 };
  
	function clean_form(theform,defval=undefined){
		$(theform).find("input").each(function (a,b){
			var df ="";
			if(defval === undefined){
				df =$(b).attr("defValue");
			} else {
				df = defval[$(b).attr("name")]
			}
			$(b).val((df===undefined)?"":df)
		})
		$(theform).find("select.select2").each(function (a,b){
			var df ="";
			if(defval === undefined){
				df =$(b).attr("defValue");
			} else {
				df = defval[$(b).attr("name")]
			}
			$(b).select2("val",((df===undefined)?"":df))
			console.log(df)
		})
		$(theform).find("textarea").each(function (a,b){
			var df ="";
			if(defval === undefined){
				df =$(b).attr("defValue");
			} else {
				df = defval[$(b).attr("name")]
			}
			$(b).text((df===undefined)?"":df)
		})
	}
	
function gravar_registro(table,callback=function(a){}){
	var dados = get_data_from_form($("#"+table+"_form form"))
	var acao = "add"
	if(dados["id"]!==undefined){
		if(dados["id"].length)
			acao = "edit";
		else 
			delete dados.id
	}
	
	
	$.ajax({
		url:"Ajax.php",
		data:{
			local:$("#"+table+"_form").attr("url"),
			acao:acao,
			dados:Base64.encode(JSON.stringify(dados))
			}
	}).done(function(a){
		if(a.error){
			message(a.error)
			} else {
			callback(a);
			voltar_tab();
			search(table,1);
		}
	})
} 	

function get_data_from_form(theForm){
	var data = {}
	$.each(theForm.serializeArray(),function(i,val){
		
		if(data[val.name]===undefined){
		
			data[val.name] = val.value
		
		} else if(Array.isArray(data[val.name])){
			data[val.name].push(val.value)
		} else {
			var a = data[val.name];
			data[val.name] = new Array()
			data[val.name].push(a);
			data[val.name].push(val.value);
		}
	})
	return data;
}
function gravar_tab(event){
		var oldTar =($(event.delegateTarget).attr("href")===undefined)?$(event.delegateTarget).attr("data-target"):$(event.delegateTarget).attr("href");
		tabList.push(oldTar);
}