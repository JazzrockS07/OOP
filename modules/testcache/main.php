<?php

use \FW\Cache\Cache as Cache;

Cache::connect('File');
$res = q("
    SELECT `id`
    FROM `users`
");
$count = $res->num_rows;
$i = 1;
$best = [];
while ($i <= 3) {
    $i = $i+1;
    $rand = rand(0,$count);

    $res2 = q("
        SELECT *
        FROM `users`
        LIMIT $rand,1
    ");
    $row = $res2->fetch_assoc();
    $best[] = $row['login'];

}
Cache::set('best',$best);

$all = [];
$res3 = q("
    SELECT *
    FROM `users`
");
while($row3=$res3->fetch_assoc()) {
    $all[] = $row3['login'];
}
Cache::set('all',$all);

echo 'Все данные внесены в кеш';
/*
Cache::set('key1','value1');
Cache::set('key2',array('ups','yo'),10000);
$data = Cache::get('key2');
echo '<pre>'.print_r($data,1).'</pre>';
*/