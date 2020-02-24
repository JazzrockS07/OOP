<?php
/*
if (empty($_GET['page2'])) {
    $_GET['page2'] = 'main';
}
*/

if (($_GET['page2']!='read')&&($_GET['page2']!='edit')&&($_GET['page2']!='login')&&($_GET['page2']!='delete')) {
    $_GET['id']=$_GET['page2'];
    $_GET['page2']='read';
}



require './'.Core::$CONT.'/'.$_GET['_module'].'/'.$_GET['_page'].'/'.$_GET['page2'].'.php';