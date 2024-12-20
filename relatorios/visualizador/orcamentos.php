<?php
date_default_timezone_set("America/Sao_Paulo");
if(!isset($dados["local"])){ die("Não foi possivel gerar o relatorio, falta do parametro 'local'");}
if(!(isset($dados["id"]))) die("Não foi possivel gerar o relatorio, falta do parametro 'id'");



//carregando serviços
$stmt = Database::conexao()->prepare("
select 
						os.id,os.valor,DATE_FORMAT( os.data, '%d\/%m\/%Y' ) as data,os.observacao,
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
						veiculos.ano as veiculoAno,
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
<style>
body{
	font-size:12px;	
}
.table{    margin-bottom:7px}
caption {
    padding-top: 4px;
    padding-bottom: 1px;
}		
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 2px;
}
h1,h2,h3,h4,h5{
	margin-bottom:3px;
	margin-top:5px
}
hr {
    margin-top: 3px;
    margin-bottom: 3px;
    border: 0;
    border-top: 1px dotted #eee;
}
</style>
<div class="row">
<div class="col-xs-8">
<?php require("cabecario.php"); ?>
</div>
<div class="col-xs-4">
<table class="table table-hover">
 <tbody>
 <tr>
  <td ><h4>O.S.:</h4></td>
  <td><h4><?php echo $dados["id"];?></h4></td>
  
 </tr>
 <tr >
  <td ><b>Data Emissao de
  relatorio</b></td>
  <td ><?php echo date("d/m/Y");?></td>
 </tr>
 <tr >
  <td><b>Hora Emissao de
  relatorio</b></td>
  <td ><?php echo date("H:i:s");?></td>
 </tr>
 </tbody>
</table>

</div></div>
<hr></hr>
<center>
<h3>Orçamento</h3></center>
<table class="table table-hover" >
<caption>Dados do orçamento</caption>
  <td><b>Nº</b></td>
  <td ><?php echo $os_s["id"];?></td>
  <td ><b>Data</b></td>
  <td ><?php echo $os_s["data"];?></td>
  <td><b>Funcionario</b></td>
  <td ><?php echo $os_s["funcionario"];?></td>
 </tr>
 <tr >
  <td ><b>Forma de pagamento</b></td>
  <td ><?php echo $os_s["formpagto"];?></td>
  <td><b>Condição de Pagamento</b></td>
  <td ><?php echo $os_s["condpagto"];?></td>
  <td ><b>Garantia</b></td>
  <td ><?php echo $os_s["garantia"];?></td>
 </tr>
</table>

<table class="table table-striped table-hover">
 <caption>Dados do cliente</caption>
 <tbody>
 <tr >
  <td ><b>Nome</b></td>
  <td ><?php echo $os_s["cliente"]?></td>
  <td ><b>Telefone</b></td>
  <td ><?php echo $os_s["clienteTelefone"]?></td>
  <td ><b>E-mail</b></td>
  <td><?php echo $os_s["clienteEmail"]?></td>
 </tr>
 <tr>
  <td ><b>CPF / CNPJ</b></td>
  <td ><?php echo $os_s["clientecnpj"]?></td>
  <td><b>IE / RG</b></td>
  <td ><?php echo $os_s["clienteie"]?></td>
  <td ><b>I. M.</b></td>
  <td ><?php echo $os_s["clienteim"]?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6513550 style='height:15.0pt'><b>Endereço</b></td>
  <td colspan=3 class=xl6313550><?php echo $os_s["clienteEndereco"]?></td>
  <td class=xl6513550><b>Cidade - UF</b></td>
  <td class=xl1513550><?php echo $os_s["clienteCidade"]." - ".$os_s["clienteEstado"]?></td>
 </tr>	
</tbody>
</table>

<table class="table table-striped table-hover">
 <caption>Dados do veiculo</caption>
 <tbody>
 <tr >
  <td ><b>Placa</b></td>
  <td ><?php echo $os_s["veiculo"]?></td>
  <td ><b>Fabricante</b></td>
  <td><?php echo $os_s["veiculoFabricante"]?></td>
  <td ><b>Modelo</b></td>
  <td ><?php echo $os_s["veiculoModelo"]?></td>
  <td ><b>Ano</b></td>
  <td ><?php echo $os_s["veiculoAno"]?></td>
 </tr>
</tbody>
</table>
<table class="table table-hover" >
<caption>Descrição dos serviços</caption>
<thead><tr><th nowrap="nowrap"><b>Tarefa</b></th><th><b>Quantidade</b></th><th><b>Valor Unit.</b></th><th><b>Valor Total</b></th></tr></thead>
<tfoot><tr><th  colspan=3 style="text-align:right;"><b>Total Da Os</b></th><th><?php echo "R$ ".number_format($os_s["valor"],2,",",".") ?></th></tr></tfoot>
<tbody>
<?php foreach($tarefas as $t){
		echo "<tr>\n";
		echo "<td nowrap=\"nowrap\" style=\"white-space: initial; width:300px\">".$t['servico']."</td>";
		echo "<td>".$t['quantidade']."</td>";
		echo "<td>"."R$ ".number_format($t['valorunit'],2,",",".")."</td>";
		$t_valortotal = $t['quantidade']*$t['valorunit'];
		echo "<td>"."R$ ".number_format($t_valortotal,2,",",".")."</td>";
		echo "</tr>\n";
	} 
	?>
</tbody>
</table>


<table class="table table-hover" >
<caption>Dados Adicionais</caption>
<tbody>
<?php
		echo "<tr>\n";
		echo "<td>".$os_s['observacao']."</td>";
		echo "</tr>\n";
	?>
</tbody>
</table>

