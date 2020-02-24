<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId            : '2335635723433028',
			autoLogAppEvents : true,
			xfbml            : true,
			version          : 'v5.0'
		});
	};
</script>
document.getElementById('responseAPI').innerHTML=escapeHtml(xmlDoc.getElementsByTagName("id")[0].childNodes[0].nodeValue);
<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
	function statusChangeCallback(response) {
		console.log('Прилитело из ФБ: ' + JSON.stringify(response));
		if (response.authResponse.userID) {
			console.log('перенаправляемся на страницу, где получаем постоянный acсess token и достаем данные');
			window.location.href = 'https://www.facebook.com/dialog/oauth?client_id=2335635723433028&redirect_uri=https://krihitki.com.ua/cab/fb_auth&response_type=code&scope=email';
		}
	}


	function fb_login(){
		FB.getLoginStatus(function(response) {
			if (response.authResponse){
				console.log('пользователь был залогинен в facebook');
				statusChangeCallback(response);
			} else {
				console.log('Юзер был не залогинен в самом ФБ, запускаем окно логинизирования');
				FB.login(function(response){
					if (response.authResponse) {
						console.log('пользователь залогинился в facebook');
						statusChangeCallback(response);
						FB.api('/me', function(response) {
							console.log('Good to see you, ' + response.name + '.');
						});
					} else {
						console.log('Походу пользователь передумал логиниться через ФБ');
					}
				});
			}
		}, {
			scope: 'public_profile,email,id'
		});
	}
</script>


<div class="body-page">
	<div class="reg">Регистрация на сайте</div><br>

	<?php if(!isset($_SESSION['regok'])) { ?>

	<div class="regist-align">
		Вы можете зарегистрироваться у нас на сайте продвинутым методом через facebook
		<br>
		<br>
		<button onclick="fb_login();return false;">Login by Facebook</button>
		<br>
		<br>
		<div id="regist-text">
			Или же обычным дедовским методом
		</div>

	</div>

	<form action="" method="post" class="reg-form">
		<table class="reg-table">
			<tr>
				<td>Логин *</td>
				<td><input id="regist-login" type="text" name="login" value="<?php if(isset($_POST['login'])) echo hc($_POST['login']); ?>"></td>
				<td><?php if(isset($errors['login'])) echo $errors['login']; ?></td>
			</tr>
			<tr>
				<td>Пароль *</td>
				<td><input type="password" name="password" value="<?php if(isset($_POST['password'])) echo hc($_POST['password']); ?>"></td>
				<td><?php if(isset($errors['password'])) echo $errors['password']; ?></td>
			</tr>
			<tr>
				<td>Email *</td>
				<td><input type="text" name="email" value="<?php if(isset($_POST['email'])) echo hc($_POST['email']); ?>"></td>
				<td><?php if(isset($errors['email'])) echo $errors['email']; ?></td>
			</tr>
			<tr>
				<td>Возраст</td>
				<td><input type="text" name="age" value="<?php if(isset($_POST['age'])) echo hc($_POST['age']); ?>"></td>
				<td></td>
			</tr>
		</table>
		<p>* поля, обязательные для заполнения</p><br>
			<input type="submit" name="sendreg" value="Зарегистрироваться">
	</form>








	<?php } else { unset($_SESSION['regok']); ?>
	<div class="reg-text">Письмо с инструкцией по активации Вашего аккаунта выслано на Ваш email</div>
	<?php } ?>

</div>

