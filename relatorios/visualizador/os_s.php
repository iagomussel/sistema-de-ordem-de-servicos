<?php
date_default_timezone_set("America/Sao_Paulo");
if(!isset($dados["local"])){ die("Não foi possivel gerar o relatorio, falta do parametro 'local'");}
if(!(isset($dados["id"]))) die("Não foi possivel gerar o relatorio, falta do parametro 'id'");



//carregando serviços
$stmt = Database::conexao()->prepare("
select 
						os.id,os.valor,DATE_FORMAT( os.data, '%d\/%m\/%Y' ) as data,
						clientes.nome as cliente,
						clientes.email as clienteEmail,
						clientes.telefone as clienteTelefone,
						clientes.endereco as clienteEndereco,
						clientes.cidade as clienteCidadeId,
						clientes.estado as clienteEstadoId,
						clientes.ie as clienteie,
						clientes.im as clienteim,
						clientes.cnpj as clientecnpj,
						cidade.Nome as clienteCidade,
						estado.Uf as clienteEstado,
						veiculos.placa as veiculo,
						veiculos.modelo as veiculoModelo,
						veiculos.fabricante as veiculoFabricante,
						funcionarios.nome as funcionario,
						formpagtos.descricao as formpagto,
						condpagtos.descricao as condpagto,
						garantias.descricao as garantia
						from os 
							LEFT join clientes on clientes.id = os.cliente
							LEFT JOIN veiculos on veiculos.id = os.veiculo
							LEFT join funcionarios on funcionarios.id = os.funcionario
							LEFT join formpagtos on formpagtos.id = os.formpagto
							LEFT join condpagtos on condpagtos.id = os.condpagto
							LEFT join cidade on cidade.id = clientes.cidade
							LEFT join estado on estado.id = clientes.estado
							LEFT join garantias on garantias.id = os.garantia  where os.id=:id");
$stmt->bindValue(":id",$dados["id"]);
$stmt->execute();
$os_s = $stmt->fetch(PDO::FETCH_ASSOC);

//tarefas
$stmt = Database::conexao()->prepare(" select * from osxservicos where idos=:id");
$stmt->bindValue(":id",$dados["id"]);
$stmt->execute();
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
<div class="col-xs-8">
<?php require("cabecario.php"); ?>
</div>
<div class="col-xs-4">
<table class="table table-hover">
 <tbody>
 <tr>
  <td ><h2>O.S.:</h2></td>
  <td class=xl1527569><h2><?php echo $dados["id"];?></h2></td>
  
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td  height=20 class=xl6627569 style='height:15.0pt'><b>Data Emissao de
  relatorio</b></td>
  <td  class=xl6427569><?php echo date("d/m/Y");?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6627569 style='height:15.0pt'><b>Hora Emissao de
  relatorio</b></td>
  <td class=xl6427569><?php echo date("H:i:s");?></td>
 </tr>
 </tbody>
</table>

</div></div>
<center>
<h1>Ordem de Serviço</h1></center>
<table class="table table-hover" >
<caption>Dados da O. S.</caption>
  <td height=20 class=xl1532300 width=159 style='height:15.0pt;width:119pt'><b>Nº</b></td>
  <td class=xl1532300 width=98 style='width:74pt'><?php echo $os_s["id"];?></td>
  <td class=xl1532300 width=164 style='width:123pt'><b>Data</b></td>
  <td class=xl1532300 width=109 style='width:82pt'><?php echo $os_s["data"];?></td>
  <td class=xl1532300 width=164 style='width:123pt'><b>Funcionario</b></td>
  <td class=xl1532300 width=92 style='width:69pt'><?php echo $os_s["funcionario"];?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532300 style='height:15.0pt'><b>Forma de pagamento</b></td>
  <td class=xl1532300><?php echo $os_s["formpagto"];?></td>
  <td class=xl1532300><b>Condição de Pagamento</b></td>
  <td class=xl1532300><?php echo $os_s["condpagto"];?></td>
  <td class=xl1532300><b>Garantia</b></td>
  <td class=xl1532300><?php echo $os_s["garantia"];?></td>
 </tr>
</table>

<table border=0 cellpadding=0 cellspacing=0 width=875 class="table table-striped table-hover">
 <caption>Dados do cliente</caption>
 <tbody>
 <tr >
  <td height=20 class=xl6513550 style='height:15.0pt'><b>Nome</b></td>
  <td class=xl1513550><?php echo $os_s["cliente"]?></td>
  <td class=xl6513550><b>E-mail</b></td>
  <td class=xl1513550><?php echo $os_s["clienteEmail"]?></td>
  <td class=xl6513550><b>Telefone</b></td>
  <td class=xl1513550><?php echo $os_s["clienteTelefone"]?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6513550 style='height:15.0pt'><b>CPF / CNPJ</b></td>
  <td class=xl1513550><?php echo $os_s["clientecnpj"]?></td>
  <td class=xl6513550><b>IE / RG</b></td>
  <td class=xl1513550><?php echo $os_s["clienteie"]?></td>
  <td class=xl6513550><b>I. M.</b></td>
  <td class=xl1513550><?php echo $os_s["clienteim"]?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6513550 style='height:15.0pt'><b>Endereço</b></td>
  <td colspan=3 class=xl6313550><?php echo $os_s["clienteEndereco"]?></td>
  <td class=xl6513550><b>Cidade - UF</b></td>
  <td class=xl1513550><?php echo $os_s["clienteCidade"]." - ".$os_s["clienteEstado"]?></td>
 </tr>	
</tbody>
</table>


<table class="table table-hover" >
<caption>Dados da O. S.</caption>
<thead><tr><th><b>Tarefa</b></th><th><b>Quantidade</b></th><th><b>Valor Unit.</b></th><th><b>Valor Total</b></th></tr></thead>
<tfoot><tr><th  colspan=3 style="text-align:right;"><b>Total Da Os</b></th><th><?php echo "R$ ".number_format($os_s["valor"],2,",",".") ?></th></tr></tfoot>
<tbody>
<?php foreach($tarefas as $t){
		echo "<tr>\n";
		echo "<td>".$t['servico']."</td>";
		echo "<td>".$t['quantidade']."</td>";
		echo "<td>"."R$ ".number_format($t['valorunit'],2,",",".")."</td>";
		$t_valortotal = $t['quantidade']*$t['valorunit'];
		echo "<td>"."R$ ".number_format($t_valortotal,2,",",".")."</td>";
		echo "</tr>\n";
	} 
	?>
</tbody>
</table>
