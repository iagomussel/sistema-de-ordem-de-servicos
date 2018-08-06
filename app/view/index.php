 
 <!DOCTYPE html>
    <html lang="pt">
    <head>

        <title>SYTECH | SISTEMAS DE INFORMAÇÃO</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="css/bootstrap.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-datepicker.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-select.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-dialog.min.css" media="all"/>
        <link rel="stylesheet" href="css/select2.min.css" media="all"/>
		<link rel="stylesheet" href="css/select2-bootstrap.min.css" media="all"/>
        <link rel="stylesheet" href="css/default.css?_=<?php echo NO_CACHE;?>" media="all"/>
        <link rel="stylesheet" href="css/print.css" media="print"/>

        <script src="js/jquery.min.js"></script>
        <script src="js/base64.js"></script>
        <script src="js/gerador.palavras.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap-dialog.min.js"></script>
        <script src="js/bootstrap-confirmation.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-datepicker.pt-BR.min.js"></script>
        <script src="js/jquery.twbsPagination.js"></script>
        <script src="js/jquery.tablesorter.min.js"></script>
		<script src="js/select2.min.js"></script>
		<script src="js/corrige.js"></script>
        <script src="index.js?_=<?php echo NO_CACHE;?>"></script>
    </head>

    <body>
        <div id="container" class="container">
            <?php
				Layout::menuDraw();
			?>

			<div style="margin-top:70px;" class="tab-content">
				<?php
					Layout::tablesDraw();
					Layout::formsDraw();
				?>
			</div>
		</div>
	</body>
</html>