<?php

if (isset($_GET['delink'])) {
    $res = q ("
			SELECT *
			FROM `users`
			WHERE `id` = ".(int)$_GET['id']."
			    AND `hash` = '".es($_GET['hash'])."'
			LIMIT 1
	");
    $rows = $res->num_rows;
    $res->close();
    if ($rows) {
        $res = q ("
			DELETE 
			FROM `users_fb`
			WHERE `user_id` = ".(int)$_GET['id']."
			LIMIT 1
	");
    }
}

if (isset($_GET['id'],$_GET['hash'])) {
    $res = q ("
			SELECT *
			FROM `users`
			WHERE `id` = ".(int)$_GET['id']."
			    AND `hash` = '".es($_GET['hash'])."'
			LIMIT 1
	");
    $rows = $res->num_rows;
    $res->close();
    if ($rows) {
        $res = q ("
			SELECT *
			FROM `users_fb`
			WHERE `user_id` = ".(int)$_GET['id']."
			LIMIT 1
	");
        $rows = $res->num_rows;
        $res->close();
    }
}

?>

<div class="body-page">
<div>
    <span class="user-text">Прилинкованная </span>
</div>
<div>
    <span class="user-text">соцсеть:</span>
    <span>
			<?php
            if ($rows!= 0) { ?>
                <span class="facebook">facebook</span>
                <a href="http://krihitki.com.ua/api/user/read?id=<?php echo $_GET['id']; ?>&hash=<?php echo $_GET['hash']; ?>&delink=yes">Отлинковать</a>
                <?php
            } else {
                echo 'отсутствует';
            }
            ?>
		</span>
</div>
</div>