<?php

session_unset();
session_destroy();
setcookie('autoauthhash','',time()-3600,'/');
setcookie('autoauthid','',time()-3600,'/');
header('Location:/');
exit();