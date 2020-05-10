<?php
	$ch = curl_init();
	
	$url = $_REQUEST['url'];
	unset($_REQUEST['url']);
	
	$queryArray = [];
	if(sizeof($_REQUEST) > 0){
		foreach($_REQUEST as $key => $value){
			$queryArray[] = $key . "=" . urlencode($value);
		}
	}
	
	if(!empty($queryArray)){
		$url .= '?'.implode("&", $queryArray);
	}
	
	curl_setopt($ch, CURLOPT_URL, 'https://old.chatplayshare.com/'.$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
	
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);

	$page = curl_exec($ch);
	if($errno = curl_errno($ch)) {
		echo $errno;
	}else{
		$page = str_ireplace('https://chatplayshare.com/','https://sosa.net/',$page);
		$page = preg_replace("/<div class=\"alert alert-success text-center\" role=\"alert\">.*?We're re-launching\!.*?<\/div>/ism","", $page);
		echo $page;
	}
	curl_close($ch);
?>