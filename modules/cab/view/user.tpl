<div class="body-page">
	<div class="user">
		Личный кабинет
	</div>

	<?php if (isset($_SESSION['userfb'])) { ?>

		<form action="" method="post" enctype="multipart/form-data">
			<div>
				<span class="user-text">Логин: </span>
				<input type="text" name="login" value="<?php if (isset($row['login'])) echo hc($row['login']); ?>" size="40" maxlength="40">
			</div>
			<div>
				<span class="user-text">e-mail: </span>
				<input type="text" name="email" value="<?php if (isset($row['email'])) echo hc($row['email']); ?>" size="40" maxlength="40">
			</div>
			<div>
				<span class="user-text">Возраст: </span>
				<input type="text" name="age" value="<?php if (isset($row['age'])) echo hc($row['age']); ?>" size="40" maxlength="40">
			</div>
			<h2><?php if (isset($error['img'])) echo $error['img']; ?></h2>
			<h2><?php if (isset($rezult)) echo $rezult; ?></h2>
			<input type="submit" name="ok" value="Редактировать данные">
		</form>
		<h2><?php if (isset($error1)) echo $error1; ?></h2>
		<?php if (isset($info)) { ?>
			<div class="user-change">
				<h2><?php echo $info; ?> </h2>
			</div>
		<?php } ?>

	<?php } else {
		echo '<br><b>Для входа в личный кабинет Вам необходимо авторизоваться!</b>';
	} ?>

	<div>
		<span class="user-text">Прилинкованная </span>
	</div>
	<div>
		<span class="user-text">соцсеть:</span>
		<span>
			<?php
				if ($rows!= 0) { ?>
					<span class="facebook">facebook</span>
					<form action="" method="post">
						<input type="submit" name="delink" value="ОТЛИНКОВАТЬ">
					</form>
			<?php
				} else {
					echo 'отсутствует';
					echo '<br><button onclick="fb_link();return false;">ПРИЛИНКОВАТЬ</button>';
				}
				?>
		</span>
	</div>
</div>

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
<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
	function statusChangeCallback(response) {
		console.log('Прилитело из ФБ: ' + JSON.stringify(response));
		if (response.authResponse.userID) {
			console.log('перенаправляемся на страницу, где получаем постоянный acсess token и достаем данные');
			window.location.href = 'https://www.facebook.com/dialog/oauth?client_id=2335635723433028&redirect_uri=https://krihitki.com.ua/cab/fb_auth_user&response_type=code&scope=email';
		}
	}


	function fb_link(){
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