<?php

use \Date\MyDate;
use \Date\DateTimeAdapter;
use \Date\MyDateAdapter;

/*
$mydate = new MyDate();
$date = $mydate->getNextDay();
$datetimeadapter = new DateTimeAdapter();
echo $datetimeadapter->format($date);
*/

$date = new MyDateAdapter();
$date->modify('+1 day');
echo $date->format('Y-m-d');