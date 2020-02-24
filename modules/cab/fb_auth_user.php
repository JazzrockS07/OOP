<?php

$config_social = array(
    "fb" => array (
        "id" => 2335635723433028,
        "redirect_url" => "https://krihitki.com.ua/cab/fb_auth_user",
        "secret" => "c4fb1cb353fb325324fb772de4d434da"
    )
);

if (isset($_GET['code'])) {
    $url = 'https://graph.facebook.com/oauth/access_token?client_id='.$config_social['fb']['id'].'&redirect_uri='.$config_social['fb']['redirect_url'].'&client_secret='.$config_social['fb']['secret'].'&fields=email&code='.$_GET['code'];
    $result_tmp = file_get_contents($url);
    $access = json_decode($result_tmp);
    $url2 = 'https://graph.facebook.com/me?access_token='.$access->access_token.'&fields=id,first_name,email';
    $result = file_get_contents($url2);
    $data = json_decode($result);
    q("
            INSERT INTO `users_fb` SET 
            `fb_id`     = ".(int)$data->id.",
            `user_id`   = ".(int)$_SESSION['userfb']['id'].",
            `fb_name`   = '".es($data->first_name)."',
            `fb_email`  = '".es($data->email)."'
        ");
    header("Location:/cab/user");
    exit();
}