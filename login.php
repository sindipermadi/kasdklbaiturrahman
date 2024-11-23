<?php
  include "inc/koneksi.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DKL Baiturrahman | Log in</title>
	<link rel="icon" href="dist/img/masjid.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<!-- Custom Style for Centering -->
	<style>
	.centered-text {
		text-align: center;
		font-size: 18px;
		margin-top: 15px;
	}
	.title-text {
		font-weight: bold;
	}
	.address-text {
		font-size: 12px;
		font-weight: normal;
		white-space: nowrap; /* Mencegah pemisahan baris */
	}
</style>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<img src="dist/img/masjid.png" width="130px" />
		</div>

		<!-- Centered Text for App Title and Address -->
		<div class="centered-text">
			<div class="title-text">Aplikasi KAS DKL Baiturrahman</div>
			<div class="address-text">Jl. Pakuan RT. 5 RW. 12 Dusun Cibiru Desa Kawali Kec. Kawali Kab. Ciamis</div>
			<br>   </div>
		</div>

		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Login System</p>

				<form action="" method="post">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="username" placeholder="Username" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" placeholder="Password" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat" name="btnLogin" title="Masuk Sistem">
								<b>Masuk</b>
							</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>

	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="dist/js/adminlte.min.js"></script>
	<script src="plugins/alert.js"></script>

</body>

</html>

<?php
if (isset($_POST['btnLogin'])) {  
	$username=mysqli_real_escape_string($koneksi,$_POST['username']);
	$password=mysqli_real_escape_string($koneksi,$_POST['password']);

	$sql_login = "SELECT * FROM tb_pengguna WHERE BINARY username='$username' AND password='$password'";
	$query_login = mysqli_query($koneksi, $sql_login);
	$data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
	$jumlah_login = mysqli_num_rows($query_login);

	if ($jumlah_login ==1 ){
		session_start();
		$_SESSION["ses_id"]=$data_login["id_pengguna"];
		$_SESSION["ses_nama"]=$data_login["nama_pengguna"];
		$_SESSION["ses_username"]=$data_login["username"];
		$_SESSION["ses_password"]=$data_login["password"];
		$_SESSION["ses_level"]=$data_login["level"];
		
		echo "<script>
			Swal.fire({title: 'Login Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
			}).then((result) => {if (result.value)
				{window.location = 'http://localhost/kas_masjid/';}
			})</script>";
	} else {
		echo "<script>
			Swal.fire({title: 'Login Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
			}).then((result) => {if (result.value)
				{window.location = 'login';}
			})</script>";
	}
}
?>
