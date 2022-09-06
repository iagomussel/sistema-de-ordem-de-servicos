<?php
date_default_timezone_set("America/Sao_Paulo");
if(!isset($dados["local"])){ die("Não foi possivel gerar o relatorio, falta do parametro 'local'");}
if(!(isset($dados["id"]))) die("Não foi possivel gerar o relatorio, falta do parametro 'id'");
//carregando cliente
$stmt = Database::conexao()->prepare("
	select *,
	cidade.nome as cidade,
	cidade.uf as uf from clientes left join cidade on clientes.cidade=cidade.id where clientes.id=:id ");
$stmt->bindValue(":id",$dados["id"]);
$stmt->execute();
$qr = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($qr)<1){
	die("cliente não encontrado");
}

$cliente = $qr[0];
//carregando veiculos
$stmt = Database::conexao()->prepare("
	select * from veiculos where veiculos.cliente=:id ");
$stmt->bindValue(":id",$dados["id"]);
$stmt->execute();
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

//carregando serviços
$stmt = Database::conexao()->prepare("select *,funcionarios.nome as funcionario,formpagtos.descricao as formpagto from os left join funcionarios on funcionarios.id=os.funcionario left join formpagtos on formpagtos.id = os.formpagto where os.data>=:data_inicial AND os.data<=:data_final AND os.status=0 AND os.cliente=:cliente_id ORDER BY data asc");
$con_perild = (strlen($dados["data_inicial"])>0&&strlen($dados["data_final"])>0);
if($con_perild){
	$ar_data_ini = explode("/",$dados["data_inicial"]);
	$ar_data_fin = explode("/",$dados["data_final"]);
	$data_inicial = mktime(0,0,0,$ar_data_ini[1],$ar_data_ini[0],$ar_data_ini[2]);
	$data_final = mktime(0,0,0,$ar_data_fin[1],$ar_data_fin[0],$ar_data_fin[2]);
} else {
	$data_inicial =mktime(0,0,0,0,0,0);
	$data_final = mktime();
}
$stmt->bindValue(":data_inicial",date("Y-m-d",$data_inicial));
	$stmt->bindValue(":data_final",date("Y-m-d",$data_final));
$stmt->bindValue(":cliente_id",$dados["id"]);
$stmt->execute();
$os_s = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<caption>Período</caption>
 <tbody>
 <tr>
  <td height=20 class=xl6327569 style='height:15.0pt'>de</td>
  <td class=xl1527569><?php echo date("d/m/Y",$data_inicial);?></td>
  <td class=xl6327569>à</td>
  <td class=xl1527569><?php echo date("d/m/Y",$data_final);?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl6627569 style='height:15.0pt'>Data Emissao de
  relatorio</td>
  <td colspan=2 class=xl6427569><?php echo date("d/m/Y");?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl6627569 style='height:15.0pt'>Hora Emissao de
  relatorio</td>
  <td colspan=2 class=xl6427569><?php echo date("H:i:s");?></td>
 </tr>
 </tbody>
</table>
</div></div>
<?php
		$cliente["quantidade_os_s"] = 0;
		$cliente["faturamento"] = 0;
		$cliente["formpagto"] = array();
		$cliente["funcionarios"] = array();
		$cliente["funcionarios_fat"] = array();
		foreach($os_s as $s){
			if($s["cliente"] == $cliente["id"]){
				$cliente["quantidade_os_s"] += 1;
				$cliente["faturamento"] += $s["valor"];
				if(!isset($cliente["formpagto"][$s["formpagto"]]))$cliente["formpagto"][$s["formpagto"]]=0;
				$cliente["formpagto"][$s["formpagto"]]+=$s["valor"];
				if(!isset($cliente["funcionarios"][$s["funcionario"]]))
					$cliente["funcionarios"][$s["funcionario"]]=0;
				if(!isset($cliente["funcionarios_fat"][$s["funcionario"]]))
					$cliente["funcionarios_fat"][$s["funcionario"]]=0;
				$cliente["funcionarios"][$s["funcionario"]]+=1;
				$cliente["funcionarios_fat"][$s["funcionario"]]+=$s["valor"];
			}
		}
		?>
		
		<table border=0 cellpadding=0 cellspacing=0 width=875 class="table table-striped table-hover">
 <caption>Dados do cliente </caption>
 <tbody>
 <tr >
  <td height=20 class=xl6513550 style='height:15.0pt'>Nome</td>
  <td class=xl1513550><?php echo $cliente["nome"]?></td>
  <td class=xl6513550>Telefone</td>
  <td class=xl1513550><?php echo $cliente["telefone"]?></td>
  <td class=xl6513550>E-mail</td>
  <td class=xl1513550><?php echo $cliente["email"]?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6513550 style='height:15.0pt'>CPF / CNPJ</td>
  <td class=xl1513550><?php echo $cliente["cnpj"]?></td>
  <td class=xl6513550>IE / RG</td>
  <td class=xl1513550><?php echo $cliente["ie"]?></td>
  <td class=xl6513550>I. M.</td>
  <td class=xl1513550><?php echo $cliente["im"]?></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6513550 style='height:15.0pt'>Endereço</td>
  <td colspan=3 class=xl6313550><?php echo $cliente["endereco"]?>, <?php echo $cliente["num"]?> | <?php echo $cliente["bairro"]." - ".$cliente["cidade"]." - ".$cliente["uf"]?></td>
  <td height=20 class=xl6513550 style='height:15.0pt'>CEP</td>
  <td colspan=3 class=xl6313550><?php echo $cliente["cep"]?></td>
  
 </tr>
</tbody>
</table>
<table class="table table-striped table-hover">
	<caption>
 Faturamento
 </caption>
 <tbody>
 <tr><td>Total de O. S.</td>
 <td><?php echo $cliente["quantidade_os_s"]?></td>
 <td>Faturamento total</td>
 <td><?php  echo "R$ ".number_format($cliente["faturamento"],2,",",".");?></td>
 
 </tr>
 
 </tbody></table>
<table class="table table-striped table-hover">
<caption>Formas de pagamento</caption>
<tbody>
<tr>
<?php foreach($cliente["formpagto"] as $ch=>$valor){?>
	
	<td class="col-xs-1"><?php echo $ch;?></td>
	<td class="col-xs-2"><?php echo "R$ ".number_format($valor,2,",",".");?></td>
	
<?php } ;?>
</tr>
</tbody>
</table>
<?php
if(count($veiculos)>0){
	?>
	<table class="table table-striped table-hover">
	   <caption>Veiculos<caption>
	  <tfoot>
	 
	  <tr><th>Placa</th><th>Modelo</th><th>Fabricante</th><th>Ano</th></tr>
</tfoot>
<tbody>
<?php
foreach($veiculos as $ch=>$valor){
echo "<tr>";
echo "<td>".$valor["placa"]."</td>";
echo "<td>".$valor["modelo"]."</td>";
echo "<td>".$valor["fabricante"]."</td>";
echo "<td>".$valor["ano"]."</td>";
echo "</tr>";
}
?>
</tbody></table>
	<?php
};
?>


<table class="table table-striped table-hover">
<caption >Rendimento Funcional</caption>
	  <tfoot>
	  
	  <tr><th>Funcionario</th><th>serviços Prestados</th><th>Rendimentos</th></tr>
	  </tfoot>
			<tbody class="row">
		<?php foreach($cliente["funcionarios"] as $ch=>$valor) {?>
		<tr>
			<td ><?php echo $ch;?></td>
			<td ><?php echo $valor;?></td>
			<td ><?php echo "R$ ".number_format($cliente["funcionarios_fat"][$ch],2,",",".");?></td>
		</tr>
		<?php };?>
		</tbody>
		
	</table>
	<h5> Situação : <?php echo $cliente["status"]?></h5>
	<?php