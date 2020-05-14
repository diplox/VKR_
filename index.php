<?php
$dbc = mysqli_connect('localhost', 'root', '', 'vkr');
if(!isset($_COOKIE['user_id'])) {
	if(isset($_POST['submit'])) {
		$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
		if(!empty($user_username) && !empty($user_password)) {
			$query = "SELECT `user_id` , `username` FROM `signup` WHERE username = '$user_username' AND password = SHA('$user_password')";
			$data = mysqli_query($dbc,$query);
			if(mysqli_num_rows($data) == 1) {
				$row = mysqli_fetch_assoc($data);
				setcookie('user_id', $row['user_id'], time() + (60*60*24*30));
				setcookie('username', $row['username'], time() + (60*60*24*30));
				$home_url = 'http://' . $_SERVER['HTTP_HOST'];
				header('Location: '. $home_url);
			}
			else {
				echo 'Извините, вы должны ввести правильные имя пользователя и пароль';
			}
		}
		else {
			echo 'Извините вы должны заполнить поля правильно';
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<meta charset="utf-8">
<link rel="stylesheet" href="style/style.css">
</head>
	
	<?php
	if(empty($_COOKIE['username'])) {
?>	
	<div class="main">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<label for="username">Логин:</label>
			<input type="text" name="username">
			<label for="password">Пароль:</label>
			<input type="password" name="password">	
			<button type="submit" name="submit">Вход</button>
			<a href="signup.php">Регистрация</a>
		</form>
	</div>
<?php
}
else {
	?>
	<div class="main">
	<p><a href="myprofile.php">Мой профиль:<?php echo $_COOKIE['username'];?></a></p>
	<p><a href="exit.php">Выйти(<?php echo $_COOKIE['username']; ?>)</a></p>
	</div>
<?php	
}
?>

</body>

</html>