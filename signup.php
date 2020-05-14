<?php
$dbc = mysqli_connect('localhost', 'root', '', 'vkr') OR DIE('Ошибка подключения к базе данных');
if(isset($_POST['submit'])){
	$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
	$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
	$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
	if(!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
		$query = "SELECT * FROM `signup` WHERE username = '$username'";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data) == 0) {
			$query ="INSERT INTO `signup` (username, password) VALUES ('$username', '$password2')";
			mysqli_query($dbc,$query);
			mysqli_close($dbc);
			$home_url = 'http://' . $_SERVER['HTTP_HOST'];//выход и перенаправления на страничку с авторизацие
			header('Location: ' . $home_url);	
			exit();
		}
		else {
			echo 'Логин уже существует';
		}
	}
	echo "Пароли не совпадают";
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<meta charset="utf-8">
<link href="style/style.css" rel="stylesheet">
</head>

<body>
	<div class="container style-warning">
		<div class="container border" style="padding: 30%">
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="d-flex justify-content-center">
						<label for="username" class="col-sm-4 col-form-label" style="height: 35px">Логин:</label>
						<input type="text" name="username" placeholder="Логин" class="rounded">
					</div>
					<div class="d-flex justify-content-center mt-4">
						<label for="password"class="col-sm-4 col-form-label" style="height: 35px">Пароль:</label>
						<input type="password" name="password1" placeholder="Пароль" class="rounded">
					</div>
					<div class="d-flex justify-content-center mt-4">
						<label for="password" class="col-sm-4 col-form-label " style="height: 35px"> Подтвердите пароль:</label>
						<input type="password" name="password2" placeholder="Пароль" class="rounded">
					 </div>
					 <div class="d-flex justify-content-center">
						<button type="submit" name="submit" class="mt-5 rounded style-warning">Зарегестрироваться</button>
					</div>
			</form>
		</div>
	</div>
</body>
</html>