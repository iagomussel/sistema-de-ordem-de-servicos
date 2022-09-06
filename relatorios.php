<?php
include("conectar.class.php");	
include("query.class.php");	
include("functions.php");
if(isset($_GET["tipo"])){
$dados = $_GET;
function random_color() {
    $letters = '0123456789ABCDEF';
    $color = '#';
    for($i = 0; $i < 6; $i++) {
        $index = rand(0,15);
        $color .= $letters[$index];
    }
    return $color;
}

function cmp_data($_a, $_b)
{
	$a_data = explode("/",$_a["data"]);
	$b_data = explode("/",$_b["data"]);
	$a = mktime(0,0,0,$a_data[1],$a_data[0],$a_data[2]);
	$b = mktime(0,0,0,$b_data[1],$b_data[0],$b_data[2]);
    if ($a == $b) {
		return 0;
    }
    return ($a < $b) ? -1 : 1;
}

?>

    <!DOCTYPE html>
    <html lang="pt">

    <head>

        <title>Auto Eletrica e Refrigeração</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="css/bootstrap.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-select.min.css" media="all"/>
		<style>
		@page {
			margin: 0.5cm;
		}
		</style>
		<style  media="print">
			.noprint{
				display:none
			}
			legend{
				text-align:center;
			}
				
		</style>
        <script src="js/jquery.min.js"></script>
        <script src="js/base64.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/defaults-pt_BR.js"></script>
        <script src="js/Chart.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
        <script src="js/Chart.js"></script>
		</head>
		<body>
		<div class="container">
<center>	<div class="noprint btn btn-default" onclick="window.print()">Imprimir</div>
		
		</center>
		<div class="body">
			<?php
			switch($_GET["tipo"]){
				case "visualizador":
					require("relatorios/visualizador.php");
				break;
				case "faturamento":
					require("relatorios/faturamento.php");
				break;
			};
			?>
		</div>
		
		</div>
		</body>
		
</html>
<?php
}
?>