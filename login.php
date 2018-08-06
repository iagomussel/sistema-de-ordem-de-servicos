  
  <?php
  
  ?>
  <!DOCTYPE html>
   <html lang="pt">

    <head>
	<title>Auto Eletrica e Refrigeração</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="css/bootstrap.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-datepicker.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-select.min.css" media="all"/>
        <link rel="stylesheet" href="css/bootstrap-dialog.min.css" media="all"/>
        <link rel="stylesheet" href="css/simple-line-icon.css" media="all"/>
	<style>
	html
	{
	height: 100%;
	margin: 0;
	padding: 0;
	}

	body
	{
	height: 100%;
	margin: 0;
	padding: 0;
	}

	body {
		background: url("img/login-bg2.jpg");
		background-size: 100%;
		background-repeat:norepeat;
	}
	</style>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <script src="js/bootstrap-dialog.min.js"></script>
        <script src="js/bootstrap-confirmation.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/bootstrap-datepicker.pt-BR.min.js"></script>
	</head>
	
	
	<body>
	<div class="container-fluid">    
        <div id="loginbox" style="margin-top:180px;" class="mainbox col-md-6 col-md-offset-6 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Sytech - sistemas de informação | Acesso restrito</div>
                        
                    </div>     
 
                    <div style="padding-top:30px" class="panel-body" >
 
                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" action="process_login.php" method="post" class="form-horizontal" role="form">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="username" name="username" type="text" class="form-control" name="username" value="" placeholder="Usuário">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="p" name="p" type="password" class="form-control" name="password" placeholder="Senha">
                                    </div>
                                    
 
                                
                            
 
 
                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
 
                                  <div class="col-sm-12 controls">
                                      <input type="submit" id="btn-login" href="#" class="btn btn-success" value="Acessar" />
 
                                    </div>
                                </div>
 
   <div style="float:right; font-size: 80%; position: relative; top:-10px">
   Caso você esqueça a senha entre em contato com nosso suporte <b>tel. (21) 98698 - 6143, email himmussel@gmail.com  </b></div>
                            </form>     
 
 
 
                        </div>                     
                    </div>  
        </div>
		<script>
		
		</script>
	</body>
</html>