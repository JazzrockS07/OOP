<?php

$config_social = array(
    "fb" => array (
        "id" => 2335635723433028,
        "redirect_url" => "https://krihitki.com.ua/cab/fb_auth",
        "secret" => "c4fb1cb353fb325324fb772de4d434da"
    )
);

if (isset($_POST['login'],$_POST['password'],$_POST['email'],$_POST['age'],$_POST['fb_id'])) {
    $errors = [];
    if(empty($_POST['login'])) {
        $errors['login'] = 'Вы не заполнили логин';
    }
    elseif(mb_strlen($_POST['login']) < 2) {
        $errors['login'] = 'Логин слишком короткий';
    }
    elseif(mb_strlen($_POST['login']) > 25) {
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
        if ($res->num_rows) {
            $errors['login'] = 'Такой логин уже занят';
        }
        $res = q("
			SELECT `id`
			FROM `users`
			WHERE `email` = '".es($_POST['email'])."'
			LIMIT 1
		");
        if ($res->num_rows) {
            $errors['email'] = 'Такой email уже занят';
        }
    }

    if(!count($errors)) {
        q("
			INSERT INTO `users` SET
			`login`		= '".es($_POST['login'])."',
			`password` 	= '".es(myHash($_POST['password']))."',
			`active`    = 1,
			`email`		= '".es($_POST['email'])."',
			`age`		= ".(int)$_POST['age'].",
			`hash`		= '".es(myHash($_POST['login'].$_POST['age']))."'
		");
        //		$id = mysqli_insert_id($link);
        $id = DB::_()->insert_id;
        q("
            INSERT INTO `users_fb` SET 
            `fb_id`     = ".(int)$_POST['fb_id'].",
            `user_id`   = ".(int)$id.",
            `fb_name`   = '".es($_POST['fb_name'])."',
            `fb_email`  = '".es($_POST['fb_email'])."'
        ");
        $_SESSION['regok'] = 'OK';
        header("Location:/cab/fb_auth");
        exit();
    }
} elseif (isset($_GET['code'])) {
    $url = 'https://graph.facebook.com/oauth/access_token?client_id='.$config_social['fb']['id'].'&redirect_uri='.$config_social['fb']['redirect_url'].'&client_secret='.$config_social['fb']['secret'].'&fields=email&code='.$_GET['code'];
    $result_tmp = file_get_contents($url);
    $access = json_decode($result_tmp);
    $url2 = 'https://graph.facebook.com/me?access_token='.$access->access_token.'&fields=id,first_name,email';
    $result = file_get_contents($url2);
    $data = json_decode($result);
    $res = q("
			SELECT *
			FROM `users_fb`
			WHERE `fb_id` = ".(int)$data->id."
			LIMIT 1
		");
    $count=$res->num_rows;
    $res->close();
    if ($count==0) {
        $message = 'Аккаунт на Ваш профиль в facebook еще не зарегистрирован. Вы можете зарегистрировать Ваш аккаунт ниже, изменив или оставив без изменения предложенный для Вашего нового аккаунта логин';
    } else {
        $message2 = 'Аккаунт на Ваш профиль в facebook уже был зарегистрирован ранее, пожалуйста авторизуйтесь через меню авторизации';
    }
}
