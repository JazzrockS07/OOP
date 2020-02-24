<?php

//Обработка регистрации

if (isset($_POST['login'],$_POST['password'],$_POST['email'],$_POST['age'])) {
    $errors = [];
    if(empty($_POST['login'])) {
        $errors['login'] = 'Вы не заполнили логин';
    }
    elseif(mb_strlen($_POST['login']) < 2) {
        $errors['login'] = 'Логин слишком короткий';
    }
    elseif(mb_strlen($_POST['login']) > 16) {
        $errors['login'] = 'Логин слишком длинный';
    }
    if(mb_strlen($_POST['password']) < 5) {
        $errors['password'] = 'Пароль должен быть длинее 4-х символов';
    }
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Вы не заполнили email';
    }

    if (!count($errors)) {
        $res = q("
			SELECT `id`
			FROM `users`
			WHERE `login` = '".es($_POST['login'])."'
			LIMIT 1
		");
        if (mysqli_num_rows($res)) {
            $errors['login'] = 'Такой логин уже занят';
        }
        $res = q("
			SELECT `id`
			FROM `users`
			WHERE `email` = '".es($_POST['email'])."'
			LIMIT 1
		");
        if (mysqli_num_rows($res)) {
            $errors['email'] = 'Такой email уже занят';
        }
    }

    if(!count($errors)) {
        q("
			INSERT INTO `users` SET
			`login`		= '".es($_POST['login'])."',
			`password` 	= '".es(myHash($_POST['password']))."',
			`email`		= '".es($_POST['email'])."',
			`age`		= ".(int)$_POST['age'].",
			`hash`		= '".es(myHash($_POST['login'].$_POST['age']))."'
		");
        //		$id = mysqli_insert_id($link);
        $id = DB::_()->insert_id;
        $_SESSION['regok'] = 'OK';
        Mail::$to = es($_POST['email']);
        Mail::$subject = 'Активация аккаунта на сайте '.Core::$DOMAIN;
        Mail::$text = '
			Для активации Вашего аккаунта на сайте перейдите по ссылке: https://'
            .Core::$DOMAIN.'/cab/activate?id='.(int)$id.'&hash='
            .hc(myHash($_POST['login'].$_POST['age'])).'
			';
        Mail::send();
        header("Location:/cab/registration");
        exit();
    }
}