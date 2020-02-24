<?php

if (isset($_POST['delink'])) {
    q ("
        DELETE
        FROM `users_fb` 
        WHERE `user_id` = ".(int)$_SESSION['userfb']['id']."
    ");
    header("Location:/cab/user");
    exit();
}

if (isset($_POST['ok'],$_POST['login'],$_POST['email'],$_POST['age'])) {

	$_POST['login'] = trimAll($_POST['login']);
    $_POST['email'] = trimAll($_POST['email']);
    $_POST['age'] = trimAll($_POST['age']);

	if(empty($_POST['login'])) {
		$error1 = 'Отсутствует логин пользователя';
	} elseif(mb_strlen($_POST['login']) < 2) {
		$error1 = 'Логин слишком короткий';
	} elseif(mb_strlen($_POST['login']) > 25) {
		$error1 = 'Логин слишком длинный';
	}
	if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error1 = 'Вы не заполнили email или формат email неправильный';
	}

	$res = q("
		SELECT *
		FROM `users`
		WHERE `id` = ".(int)$_SESSION['userfb']['id']."
	");
	$row=$res->fetch_assoc();
	if ($_POST['login']!=$row['login']) {
		$res = q("
	  	SELECT `id`
	  	FROM `users`
	  	WHERE `login` = '".es($_POST['login'])."'
	  	LIMIT 1
	");
		if (mysqli_num_rows($res)) {
			$error1 = 'Такой логин уже занят';
		}
	}

	$res = q("
		SELECT *
		FROM `users`
		WHERE `id` = ".(int)$_SESSION['userfb']['id']."
	");
	$row=$res->fetch_assoc();
	if ($_POST['email']!=$row['email']) {
		$res = q("
	  	SELECT `id`
	  	FROM `users`
	  	WHERE `email` = '".es($_POST['email'])."'
	  	LIMIT 1
	");
		if (mysqli_num_rows($res)) {
			$error1 = 'Такой email уже занят';
		}
	}

	if (!isset($error1)){
		$res = q("
			UPDATE `users` SET
			`login`			='".es($_POST['login'])."',
			`email`			='".es($_POST['email'])."',
			`age`		=".(int)$_POST['age']."
			WHERE `id` = ".(int)$_SESSION['userfb']['id']."
		");
		$_SESSION['info'] = 'Данные пользователя были успешно изменены';
	}
}

if (isset($_SESSION['user'])) {
    $user = q ("
			SELECT *
			FROM `users`
			WHERE `id` = ".(int)$_SESSION['user']['id']."
			LIMIT 1
	");
    $row = mysqli_fetch_assoc($user);
}

if (isset($_SESSION['userfb'])) {
    $res = q ("
			SELECT *
			FROM `users`
			WHERE `id` = ".(int)$_SESSION['userfb']['id']."
			LIMIT 1
	");
    $row = mysqli_fetch_assoc($res);
	$res = q ("
			SELECT *
			FROM `users_fb`
			WHERE `user_id` = ".(int)$_SESSION['userfb']['id']."
			LIMIT 1
	");
	$rows = $res->num_rows;
	$res->close();
}

if (isset($_SESSION['info'])) {
	$info = $_SESSION['info'];
	unset($_SESSION['info']);
}


