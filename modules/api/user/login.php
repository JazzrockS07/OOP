<?php

// Code to convert php array to xml document

// Define a function that converts array to xml.
function arrayToXml($array, $rootElement = null, $xml = null) {
    $_xml = $xml;

    // If there is no Root Element then insert root
    if($_xml === null) {
        $_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
    }

    // Visit all key value pair
    foreach($array as $k => $v) {

        // If there is nested array then
        if(is_array($v)) {

            // Call function for nested array
            arrayToXml($v, $k, $_xml->addChild($k));
        }

        else {

            // Simply add child element.
            $_xml->addChild($k, $v);
        }
    }

    return $_xml->asXML();
}

if (isset($_POST['login'],$_POST['password'],$_POST['response'])) {
    $res = q("
		SELECT *
		FROM `users`
		WHERE `login`		= '".es($_POST['login'])."'
			AND `password`	= '".es(myHash($_POST['password']))."'
			AND `active`	= 1
		LIMIT 1
	");
    if ($res->num_rows) {
        $row=$res->fetch_assoc();
        $user=array();
        $user['id']=$row['id'];
        $user['hash']=$row['hash'];
    } else {
        $user['error'] = 'пользователь с таким логином и паролем не зарегистрирован';
    }
}

if ($_POST['response'] == 'json') {
    $result=json_encode($user);
} elseif($_POST['response'] == 'xml'){
    $result=arrayToXml($user);
}

echo $result;