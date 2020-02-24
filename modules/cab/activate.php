<?php

//Обработка активации

if (isset($_GET['hash'])) {
	q("
		UPDATE `users` SET
		`active` = 1
		WHERE `id` = ".(int)$_GET['id']." 
		AND `hash` = '".es($_GET['hash'])."'
		AND `active` = 0
	");
	$info = 'Ваша учетная запись активирована';
} else {
	$info = 'Вы прошли по неверной ссылке';
}