<?php
session_start();
$secretWord = $_SESSION['secret_word'];
$filePathOld = '../JS-old/js_old.js';
$filePathNew = '../JS-new/js_new.js';
$handleOld = fopen($filePathOld,'r');
$handleNew = fopen($filePathNew,'w+');
$count = 0;
WHILE($string = fgets($handleOld)){
	$string = changeComments($string);
	$string = trim($string);
	$str[]=$string;
	$count ++;
	if ($count >=20){
		writeToFile($str,$handleNew,$secretWord);
		$count = 0;
		$str = null;
	}
}
writeToFile($str,$handleNew,$secretWord);

/* functions to code existing JS */

//function that transform comments
function changeComments(&$string)
{
	$pattern = '/(\/\/)(.+)$/';
	$replacer = '/* \2 */';
	$string = preg_replace($pattern,$replacer,$string);
	return $string;
}

// function that cut new lines and join everything into one line
function writeToFile($str,$handleNew,$key)
{
	$code = implode(" ",$str);
	$code = str_replace("\n"," ",$code);
	$code = str_replace("\r"," ",$code);
	$code = str_replace("}","};",$code);
	if(preg_match('/\/\*[^\*\/]+\*\//',$code)==1){
		$code = commentEncryptor($code,$key);
	}
	print_r($code);
	fwrite($handleNew,$code);
}

//function that encrypt comments
function commentEncryptor($code,$key)
{
	echo "<pre>";
	$pattern = '/\/\*[^\*\/]+\*\//';
	preg_match_all($pattern,$code,$matches);
	var_dump($matches);
	foreach ($matches[0] as $value)
	{
		$oldValue = $value;
		// remove /* and */
		$oldValueClean = preg_replace('/\/\*([^\*\/]+)\*\//','(\1)',$oldValue);
		var_dump($oldValueClean);
		$mc_d = mcrypt_module_open(MCRYPT_BLOWFISH,'',MCRYPT_MODE_CFB,'');
		$iv_size = mcrypt_enc_get_iv_size($mc_d);
		$iv = mcrypt_create_iv($iv_size,MCRYPT_RAND);
		mcrypt_generic_init($mc_d,$key,$iv);
		$newValue = mcrypt_generic($mc_d,$oldValue);
		mcrypt_generic_deinit($mc_d);
		$newValue = '/*'.$newValue.'*/';
		$code = str_replace($oldValue,$newValue,$code);
	}
	return $code;
}




