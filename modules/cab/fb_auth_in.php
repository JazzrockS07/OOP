<?php

$config_social = array(
    "fb" => array (
        "id" => .............,
        "redirect_url" => "https://..............",
        "secret" => "............."
    )
);

if (isset($_GET['code'])) {
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
    $row=$res->fetch_assoc();
    $res->close();
    if ($count==0) {
        $message = 'Аккаунт на Ваш профиль в facebook еще не зарегистрирован. Зарегистрируйтесь пожалуйста на странице регистрации';
    } else {
        $res = q("
		SELECT *
		FROM `users`
		WHERE `id`		= '".es($row['user_id'])."'
		LIMIT 1
	");
        if (mysqli_num_rows($res)) {
            $_SESSION['userfb'] = mysqli_fetch_assoc($res);
            $status = 'OK';
            header("Location:/cab/user");
            exit();
        }
    }
}
