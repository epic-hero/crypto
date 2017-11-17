<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta charset="utf-8">	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
 
	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
 
	<script src="bootstrap/js/bootstrap.min.js"></script>
	 
	<style>
		.image{
			height: 100%;
			background-repeat: no-repeat;
			margin: auto;
			width: 600px;
		}
		.navbar-brand {
			padding: 0px;
		}
		.navbar-brand>img {
			height: 60px;
			width: auto;
		}
		.container-fluid{
			margin-left:100px;
		}
		[name="rotor_second"], [name="rotor_third"]{
			    margin-left: 10px;
		} 
		.rotor_settings{
			    margin-bottom: 24px;
		}
	</style>
</head>
<body>
	<?php
		require_once 'CryptoEncoder.php'; 
		
		$result = '';
		$post = $_POST;
		$input_text = mb_strtoupper($post["text"]);
		$settings = [];
		$settings['rotor_first'] = $post['rotor_first'];
		$settings['rotor_second'] = $post['rotor_second'];
		$settings['rotor_third'] = $post['rotor_third'];
		 
		if(isset($post['encoder'])){

			$cryptoEncoder = new CryptoEncoder;
			
			$cryptoEncoder->rotorSettings($settings);

			for($j = 0; $j < strlen(trim($input_text)); $j++){
				$result .= $cryptoEncoder->rotorStart($input_text[$j]);  
			}
		}
		
	?>
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="index.php"><img src="http://is1.mzstatic.com/image/thumb/Purple/v4/70/f7/af/70f7af88-3686-eba4-e7f0-269eab778dfb/source/175x175bb.jpg"></a>
		</div>
		<ul class="nav navbar-nav">
		  <!--<li class="active"><a href="http://y9124500.beget.tech/laba/">Жорданово исключение</a></li>-->
		</ul> 
	  </div>
	</nav>
	<div class="container">
		<form action="index.php" method="POST" class="form-horizontal">
			<div class="form-inline rotor_settings">
				 <div class="form-group">
					<p><b>Задать настройки роторов:</b></p>
					<input type="number" class="col-md-3" name="rotor_first" placeholder="" value="0" min="0" max="26">
					<input type="number" class="col-md-3" name="rotor_second" placeholder="" value="0" min="0" max="26">
					<input type="number" class="col-md-3" name="rotor_third" placeholder="" value="0" min="0" max="26">
				</div> 
			</div>
			<div class="form-group">
				<label>Текст:</label>
				<textarea class="form-control" name="text" placeholder="Введите текст" required><?= $result;?></textarea><br/>
				<input type="submit" name="encoder" class="btn btn-primary" value="Encoder">
			</div>
		</form>
		
		<?php if($input_text):?>
			<p><b>Изначальный текст:</b></br> <?=$input_text;?></p>
		<?php endif;?>
		
		<div class="image"></div>
	</div>

</body>
</html>
