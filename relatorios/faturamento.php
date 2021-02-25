<?php
date_default_timezone_set("America/Sao_Paulo");
$incluirdados = (isset($dados["graficos"])&&$dados["graficos"]);


if(!isset($dados["data_inicial"]))$dados["data_inicial"]="";
$data_inicial = strtotime($dados["data_inicial"]);

if(isset($dados["data_final"])&&strlen($dados["data_final"]))
	$data_final = strtotime($dados["data_final"]);
else
	$data_final=time();
if(!isset($dados["ordenar_por"]))$dados["ordenar_por"]="data";
$ordenar_por = $dados["ordenar_por"];
$stmt = Database::conexao()->prepare("select 
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
							LEFT join garantias on garantias.id = os.garantia  where os.data>=:data_inicial AND os.data<=:data_final AND os.status=0 ORDER BY data asc");
$ar_data_ini = explode("/",$dados["data_inicial"]);
$ar_data_fin = explode("/",$dados["data_final"]);
$data_inicial = mktime(0,0,0,$ar_data_ini[1],$ar_data_ini[0],$ar_data_ini[2]);
$data_final = mktime(0,0,0,$ar_data_fin[1],$ar_data_fin[0],$ar_data_fin[2]);
$stmt->bindValue(":data_inicial",date("Y-m-d",$data_inicial));
$stmt->bindValue(":data_final",date("Y-m-d",$data_final));
$stmt->execute();
$os_s = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
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
</div></div><center><h3>Faturamento por periodo</h3></center>
<?php
		$faturamento = 0;
		$faturamento_data = array() ;
		$faturamento_total_data = array() ;
		$total_por_cond = array();
		foreach( $os_s as $ch=>$s){
			$faturamento+=$s["valor"];
			if(!isset($faturamento_data[$s[$ordenar_por]])){
				$faturamento_data[$s[$ordenar_por]]=array();
				$faturamento_total_data[$s[$ordenar_por]]=0;
			}
			if(!isset($faturamento_data[$s[$ordenar_por]][$s["formpagto"]]))
				$faturamento_data[$s[$ordenar_por]][$s["formpagto"]]=0;
			if(!isset($total_por_cond[$s["formpagto"]]))$total_por_cond[$s["formpagto"]]=0;
			$total_por_cond[$s["formpagto"]] +=$s["valor"];
			$faturamento_total_data[$s[$ordenar_por]]+=$s["valor"];
			$faturamento_data[$s[$ordenar_por]][$s["formpagto"]]+=$s["valor"];
		}
		?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				Faturamento por período
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<thead> <tr><th>$ordenar_por</th>
					<?php 
					foreach($total_por_cond as $cond=>$c){
					 echo "<th>".$cond."</th>";
					}
					?>
					
					<th>Valor</th></tr></thead>
					<tbody>
					<?php
					foreach($faturamento_data as $s=>$v){
						echo "<tr><td>".$s."</td>";
						foreach($total_por_cond as $cond=>$c){
							
							if(isset($v[$cond]))
								echo "<td>"."".number_format($v[$cond],2,",",".")."</td>";
							else
								echo "<td> - </td>";
						}
						echo "<td>"."R$".number_format($faturamento_total_data[$s],2,",",".")."</td>";
						echo "</tr>";
					}
					?>
					</tbody>
					<tfoot>
					<tr><td>Resumo</td>
					<?php
					foreach($total_por_cond as $cond=>$c){
					 echo "<td>". "R$".number_format($c,2,",",".")."</td>";
					}
					?>
					<td><?php echo "R$".number_format($faturamento,2,",","."); ?></td></tr>
					</tfoot>
					</table>
					
				</div>
			</div>
			<div class="panel-footer">
			<div class="row">
				<div class="col-xs-offset-6 col-xs-3">
				<strong>Faturamento no período</strong>
				</div>
				<div class="col-xs-3"><strong>
				<?php echo "R$ ".number_format($faturamento,2,",","."); ?></strong>
				</div>
			</div>
			</div>
		</div>
		<?php if($incluirdados) {

			
			
			
			?>
					<div class="row">
						<div class="col-xs-offset-1 col-xs-10 box-chart">
						  <canvas id="condpagto_graf"></canvas>
						</div>
					</div>
					<script type="text/javascript">
						
						
						
						var options = {
							responsive:true
						};

						var data={
							type: "<?php echo (isset($dados["tipo_graf"]))?$dados["tipo_graf"]:"pie"; ?>",
							data:{
							labels: [<?php 
									foreach($total_por_cond as $cond=>$c){
									 echo "\"".$cond."\",";
									}
							?>],
							datasets: [
								{
									label: "Formas De Pagto.",
									backgroundColor: [
										'rgba(255, 99, 132, 0.2)',
										'rgba(54, 162, 235, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
									],
									borderColor: [
										'rgba(255,99,132,1)',
										'rgba(54, 162, 235, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
									],
									
									data: [<?php
									foreach($total_por_cond as $cond=>$c){
									 echo $c.",";
									}
									?>]
								}
							],
							options:options
						}};
						var ctx = document.getElementById("condpagto_graf").getContext("2d");
						var LineChart = new Chart(ctx,data);
					</script>
					<?php }?>
		