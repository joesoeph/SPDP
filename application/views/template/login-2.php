<!DOCTYPE html>
<head>
	<!-- templatemo 418 form pack -->
    <!-- 
    Form Pack
    http://www.templatemo.com/preview/templatemo_418_form_pack 
    -->
	<title>Login</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/vendor/templatemo_418_form_pack/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/vendor/templatemo_418_form_pack/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/vendor/templatemo_418_form_pack/css/bootstrap-theme.min.css');?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/vendor/templatemo_418_form_pack/css/bootstrap-social.css');?>" rel="stylesheet" type="text/css">	
	<link href="<?=base_url('assets/vendor/templatemo_418_form_pack/css/templatemo_style.css');?>" rel="stylesheet" type="text/css">	
	<style>
		.templatemo-bg-image-1 {
			background-color: rgb(60,60,60);
			background-image: url('https://ik.imagekit.io/dz5f3sbago/pexels-lukas-590037_WHOsWGS8V.jpg');
		}
	</style>
</head>
<body class="templatemo-bg-image-1">
	<div class="container">
		<div class="col-md-12">			
			<form class="form-horizontal templatemo-login-form-2" role="form" action="<?= base_url('auth/doLogin'); ?>" method="post">
				<div class="row">
					<div class="col-md-12">
						<h1>PROXIS</h1>
						<h2>Login</h2>
					</div>
				</div>
				<div class="row">
					<div class="templatemo-signin col-md-3">
				        <div class="form-group">
				          <div class="col-md-6">		          	
				            	            		            		            
				          </div>              
				        </div>
					</div>
					<div class="templatemo-signin col-md-6">
				        <div class="form-group">
				          <div class="col-md-12">		          	
				            <label for="username" class="control-label">Username</label>
				            <div class="templatemo-input-icon-container">
				            	<i class=""></i>
				            	<input type="text" class="form-control" id="username" placeholder="" name="username">
				            </div>		            		            		            
				          </div>              
				        </div>
				        <div class="form-group">
				          <div class="col-md-12">
				            <label for="password" class="control-label">Password</label>
				            <div class="templatemo-input-icon-container">
				            	<i class=""></i>
				            	<input type="password" class="form-control" id="password" placeholder="" name="password">
				            </div>
				          </div>
				        </div>
				        <div class="form-group">
				          <div class="col-md-12">
				            <input type="submit" value="LOG IN" class="btn btn-warning">
				          </div>	
				        </div>
					</div>   
				</div>				 	
		      </form>		      		      
		</div>
	</div>
</body>
</html>
