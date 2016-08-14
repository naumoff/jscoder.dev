<?php
session_start();
$secretWord = $_SESSION['secret_word'];
$funcEncryptStatus = $_SESSION['function_encrypt'];
var_dump($funcEncryptStatus);
$filePathOld = '../JS-old/js_old.js';
$filePathNew = '../JS-new/js_new.js';
$handleOld = fopen($filePathOld,'r');
$handleNew = fopen($filePathNew,'w+');
$count = 0;
WHILE($string = fgets($handleOld)){
	$string = changeComments($string);
	$string = trim($string);
	// if string ends on ';' we insert fake functions
	// random quantity of random functions
	$pattern = '/;$/';
	if (preg_match($pattern,$string) == 1){
		fakeFunctionsInsert($string);
		$instance += 1;
		echo $instance;
	}
	$str[]=$string;
	unset($string);
	$count ++;
	echo 'Written!';
	if ($count >=100){
		writeToFile($str,$handleNew,$secretWord,$funcEncryptStatus);
		$count = 0;
		unset($str);
	}
}
writeToFile($str,$handleNew,$secretWord,$funcEncryptStatus);

/* functions to code existing JS */

//function that transform comments into one format - /* comment */
function changeComments(&$string)
{
	$pattern = '/(\/\/)(.+)$/';
	$replacer = '/* \2 */';
	$string = preg_replace($pattern,$replacer,$string);
	return $string;
}

// function that cut new lines and join everything into one line
function writeToFile($str,$handleNew,$key,$funcEncryptStatus)
{
	$code = implode(" ",$str);
	$code = str_replace("\n","",$code);
	$code = str_replace("\r","",$code);
	$code = preg_replace('/}/','};',$code);
	if(preg_match('/\/\*[^\*\/]+\*\//',$code)==1){
		$code = commentEncryptor($code,$key);
	}
	$code = functionEncrypt($code,$funcEncryptStatus,$key);
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
		// $oldValueClean has removed /* and */
		$oldValueClean = preg_replace('/\/\*([^\*\/]+)\*\//','(\1)',$oldValue);
		$mc_d = mcrypt_module_open(MCRYPT_BLOWFISH,'',MCRYPT_MODE_CFB,'');
		$iv_size = mcrypt_enc_get_iv_size($mc_d);
		$iv = mcrypt_create_iv($iv_size,MCRYPT_RAND);
		mcrypt_generic_init($mc_d,$key,$iv);
		$newValue = mcrypt_generic($mc_d,$oldValueClean);
		$newValue = base64_encode($iv.$newValue);
		mcrypt_generic_deinit($mc_d);
		$newValue = '/*'.$newValue.'*/';
		$code = str_replace($oldValue,$newValue,$code);
	}
	return $code;
}

//function that inserts fake functions & variables from external file
// ../FakeData/JS-functions.php
function fakeFunctionsInsert(&$string)
{
	include '../FakeData/JS-functions.php';
	$count = count($fakeFunc)-1;
	$quantity = rand(1,3);
	
	for ($x = 0; $x <=$quantity; $x++)
	{
		$key = rand(1,$count);
		$string = $string . $fakeFunc[$key];
	}
}

// function that encrypt function names
function functionEncrypt($code,$funcEncryptStatus,$key)
{
	if($funcEncryptStatus == 1){
		$pattern = '/function (?P<funcName>[a-zA-Z0-9-_]*)/';
		preg_match_all($pattern,$code,$matches);
		$matches = array_unique($matches['funcName']);
		$matches = array_values($matches);
		$count = count($matches)-1;
		for($cycle = 0; $cycle<=$count; $cycle++)
		{
			$funcName = $matches[$cycle];
			var_dump($funcName);
			// checks that function name has no variable namesake
			$pattern = "/(var $funcName|$funcName=|$funcName =)/";
			if(preg_match_all($pattern,$code) == 0){
				$newValue = encryptor($funcName,$key);
				var_dump($newValue);
			}else{
				$newValue = $funcName;
				var_dump($newValue);
			}
			$code = str_replace($funcName,$newValue,$code);
		}
		
		return $code;
	} else {
		return $code;
	}
}

// function that encryt total name of function (prefix + functionName + suffix)
function encryptor($text,$key)
{
	$fix = str_split($key);
	
	foreach ($fix as $value)
	{
		$preFix[] = prefixName($value);
	}
	$prefix = 'func'.implode('',$preFix);
	
	foreach ($fix as $value)
	{
		$sufFix[] = suffixName($value);
	}
	$suffix = strrev(implode('',$sufFix));
	
	$text = str_split($text);
	foreach ($text as $value)
	{
		$newValue[] = coderName($value);
	}
	$newValue = $prefix.implode('',$newValue).$suffix;
	return $newValue;
}

// Function encrypt function name based on file ../FakeData/LetterDescriptor
function coderName($value)
{
	include '../FakeData/LetterDescriptor.php';
	foreach ($descriptor as $key=>$oldValue)
	{
		if($value == $oldValue){
			$value = $key;
		}
	}
	return $value;
}

// function encypt prefix based on $key provided by User
function prefixName($value)
{
	include '../FakeData/LetterDescriptor.php';
	foreach ($prefixDescriptor as $key=>$oldValue)
	{
		if($value == $oldValue){
			$value = $key;
		}
	}
	return $value;
}

// function encrypt suffix using $key provided by User
function suffixName($value)
{
	include '../FakeData/LetterDescriptor.php';
	foreach ($suffixDescriptor as $key=>$oldValue)
	{
		if($value == $oldValue){
			$value = $key;
		}
	}
	return $value;
}