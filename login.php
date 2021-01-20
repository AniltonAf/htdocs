<!DOCTYPE html>
<html lang="en">

<head>
	<title>SysGer v1.0</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="shortcut icon" href="dist/img/CaixaLogo.png">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="dist/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="dist/login/css/main.css">
	<!--===============================================================================================-->
</head>

<body style="background-color: #666666;">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" name="login" method="post">
					<span class="login100-form-title p-b-43">
						<img src="dist/img/logo_caixa.png" style="max-height: 70px">
					</span>

					<div class="retorno"></div>
					<div class="wrap-input100 validate-input" data-validate="Nome utilizador Obrigratório">
						<input class="input100" type="text" name="username">
						<span class="focus-input100"></span>
						<span class="label-input100">Nome Utilizador</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Palavra-passe obrigatório">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Palavra-passe</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Lembrar-me
							</label>
						</div>

						<div>
							<a href="dist/login/#" class="txt1">
								Esqueceu Palavra-Passe?
							</a>
						</div>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('dist/img/login-background-image.jpg');">
					<div style="width: 100%; height: 100%;background-color: rgba(0,0,0,0.7);">

					</div>
				</div>
			</div>
		</div>
	</div>





	<!--===============================================================================================-->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!--===============================================================================================-->
	<script src="dist/login/vendor/animsition/js/animsition.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="dist/login/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="dist/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="dist/login/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="dist/login/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="dist/login/js/main.js"></script>
	<script type="text/javascript" src="backend/login/script.js"></script>

</body>

</html>