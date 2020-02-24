<div class="body-page">
	<div class="auth">Авторизация на сайте</div><br>

	<div class="auth-form">
		<?php if(!isset($status) || $status != 'OK') { if (isset($errors)) echo $errors; ?>
		<form action="" method="post">
			<table class="auth-table">
				<tr>
					<td>Логин </td>
					<td><input type="text" name="login"></td>
				</tr>
				<tr>
					<td>Пароль </td>
					<td><input type="password" name="pass"></td>
				</tr>
			</table>
			<br>
			Запомнить меня: <input type="checkbox" name="autoauth"><br><br>
			<input type="submit" name="submit" value="Вход">
		</form>
		<?php } else { ?>
			<div class="auth-text">Поздравляем, Вы авторизованы</div>
		<?php } ?>
	</div>

</div>