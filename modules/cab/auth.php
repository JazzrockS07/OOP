<?php

if (isset($_POST['login'],$_POST['pass'])) {
	$res = q("
		SELECT *
		FROM `users`
		WHERE `login`		= '".es($_POST['login'])."'
			AND `password`	= '".es(myHash($_POST['pass']))."'
			AND `active`	= 1
		LIMIT 1
	");
	if (mysqli_num_rows($res)) {
		$_SESSION['userfb'] = mysqli_fetch_assoc($res);
		$status = 'OK';
		//если стоит галочка создать куки и запись в базе данных
		if (isset($_POST['autoauth'])) {
			setcookie('autoauthhash',myHash($_SESSION['userfb']['id'].$_SESSION['userfb']['login'].$_SESSION['userfb']['email']),
				time()+3600*24*30*12,'/');
			setcookie('autoauthid',$_SESSION['userfb']['id'],time()+3600*24*30*12,'/');
			q("
				UPDATE `users` SET
				`hash`		= '".es(myHash($_SESSION['userfb']['id'].$_SESSION['userfb']['login'].$_SESSION['userfb']['email']))."',
				`ip_address`	= '".es($_SERVER['REMOTE_ADDR'])."'
				WHERE `login`		= '".es($_POST['login'])."'
				AND `password`	= '".es(myHash($_POST['pass']))."' 
			");
			$res = q("
				SELECT *
				FROM `users`
				WHERE `login`		= '".es($_POST['login'])."'
					AND `password`	= '".es(myHash($_POST['pass']))."'
					AND `active`	= 1
				LIMIT 1
			");
			$_SESSION['userfb'] = mysqli_fetch_assoc($res);
		}
	} else {
		$errors = 'Нет пользователя с таким логином или паролем';
	}
}

