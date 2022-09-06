<?php
date_default_timezone_set("America/Sao_Paulo");
if(!isset($dados["local"])){ die("Não foi possivel gerar o relatorio, falta do parametro 'local'");}
if(!(isset($dados["id"]))) die("Não foi possivel gerar o relatorio, falta do parametro 'id'");
//carregando cliente
$stmt = Database::conexao()->prepare("
	select * from funcionarios where funcionarios.id=:id ");
$stmt->bindValue(":id",$dados["id"]);
$stmt->execute();
$qr = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($qr)<1){
	die("funcionario não encontrado");
}

$funcionario = $qr[0];
//carregando serviços
$stmt = Database::conexao()->prepare("
select *,DATE_FORMAT( os.data, '%d\/%m\/%Y' ) as data,clientes.nome as cliente from os left join clientes on clientes.id=os.cliente where os.data>=:data_inicial AND os.data<=:data_final AND os.status=0 AND os.funcionario=:funcionario_id ORDER BY data asc");
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
$stmt->bindValue(":funcionario_id",$dados["id"]);
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
		$funcionario["quantidade_os_s"] = 0;
		$funcionario["faturamento"] = 0;
		foreach($os_s as $s){
			if($s["funcionario"] == $funcionario["id"]){
				$funcionario["quantidade_os_s"] += 1;
				$funcionario["faturamento"] += $s["valor"];
				
			}
		}
		?>
		
		<table border=0 cellpadding=0 cellspacing=0 width=875 class="table table-striped table-hover">
 <caption>Dados do Funcionario</caption>
 <tbody>
 <tr >
  <td >Nome</td>
  <td class=xl1513550><?php echo $funcionario["nome"]?></td>
  <td class=xl6513550>Telefones</td>
  <td class=xl1513550><?php echo $funcionario["telefone1"]?></td>
  <td class=xl6513550><?php echo $funcionario["telefone2"]?></td>
  <td class=xl1513550><?php echo $funcionario["telefone3"]?></td>
  
 </tr>
 
</tbody>
</table>
<table class="table table-striped table-hover">
	<caption>
 Faturamento
 </caption>
 <tbody>
 <tr><td>Total de O. S.</td>
 <td><?php echo $funcionario["quantidade_os_s"]?></td>
 <td>Faturamento total</td>
 <td><?php  echo "R$ ".number_format($funcionario["faturamento"],2,",",".");?></td>
 
 </tr>
 
 </tbody></table>


<table class="table table-striped table-hover">
<caption >Servicos realizados</caption>
	  <tfoot>
	  
	  <tr><th>Data</th><th>Cliente</th><th>Veiculo</th></tr>
	  </tfoot>
			<tbody class="row">
		<?php foreach($os_s as $ch=>$valor) {?>
		<tr>
			<td ><?php echo $valor["data"];?></td>
			<td ><?php echo $valor["cliente"];?></td>
			<td ><?php echo "R$ ".number_format($valor["valor"],2,",",".");?></td>
		</tr>
		<?php };?>
		</tbody>
		
	</table>
