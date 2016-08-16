<?php
session_start();
$secretWord = $_SESSION['secret_word'];
$funcEncryptStatus = $_SESSION['function_encrypt'];
$varEncryptStatus = $_SESSION['variable_encrypt'];
$fakeInsertStatus = $_SESSION['fake_data'];
$newFilePath = $_SESSION['newFilePath'];
?>
<pre>
<?php
print_r($_SESSION);

// open downloaded decoded file and assign its content to $code string variable
$handle = fopen($newFilePath,'r');
$code = fread($handle,filesize($newFilePath));
var_dump($code);

//decoding comments part
$pattern = '/\/\*.+?\*\//';
preg_match_all($pattern,$code,$matches);
var_dump($matches);
$oldValue = $matches[0];
$count = count($oldValue)-1;
$cycle = 0;

for($cycle = 0; $cycle<=$count; $cycle++) {
	$newValue[$cycle] = commentDecoder($oldValue[$cycle], $secretWord);
	$code = str_replace($oldValue[$cycle],$newValue[$cycle],$code);
}

// decoding function names
if($funcEncryptStatus == 1){
	//retrieved coded prefix of funcName
	$prefix = prefixDecoder($secretWord);
	print_r($prefix);
	
	//retrieved coded suffix of funcName
	$suffix = suffixDecoder($secretWord);
	print_r($suffix);
	
	//retrieved coded core name of funcName
	$pattern = "/$prefix(?P<funcName>.+?)$suffix/";
	preg_match_all($pattern,$code,$matches);
	$oldCoreFuncName = array_unique($matches['funcName']);
	print_r($oldCoreFuncName);
	
	//retrieved array codedFullFuncName=>codedCoreFuncName
	foreach ($oldCoreFuncName as $key=>$value)
	{
		$oldFuncName[$prefix.$oldCoreFuncName[$key].$suffix] = $oldCoreFuncName[$key];
	}
	print_r($oldFuncName);
	
	//retrieved array codedFullFuncName=>decodedCoreFuncName
	$decodedFuncNameArray = functionDecoder($oldFuncName);

}

print_r($code);

/* ***************************************** */
/* bundle of functions engaged in this script*/
/* ***************************************** */

//comment decoder function
function commentDecoder($value,$secretWord)
{
	$pattern = '/\/\*(.+)\*\//';
	$replacer = '\1';
	$value = preg_replace($pattern,$replacer,$value);
	$value = base64_decode($value);
	var_dump($value);
	$mc_d = mcrypt_module_open(MCRYPT_BLOWFISH,'',MCRYPT_MODE_CFB,'');
	$iv_size = mcrypt_enc_get_iv_size($mc_d);
	$iv = substr($value,0,$iv_size);
	$crypt_text = substr($value,$iv_size);
	mcrypt_generic_init($mc_d,$secretWord,$iv);
	$value = mdecrypt_generic($mc_d,$crypt_text);
	mcrypt_generic_deinit($mc_d);
	$value = "/* {$value} */";
	return $value;
}

// function that detects prefix of coded function
function prefixDecoder($secretWord)
{
	$prefixArray = str_split($secretWord);
	print_r($prefixArray);
	$count = count($prefixArray)-1;
	include '../../Encryptors/LetterDescriptor.php';
	for($cycle=0; $cycle<=$count; $cycle++)
	{
		foreach ($prefixDescriptor as $key => $value)
		{
			$pattern = "/{$prefixArray[$cycle]}/";
			if(preg_match($pattern,$value)==1){
				$prefixArray{$cycle} = $key;
			}
		}
	}
	$prefix = 'func'.implode('',$prefixArray);
	var_dump($prefix);
	return $prefix;
}

// function that detects suffix of coded function
function suffixDecoder($secretWord)
{
	$suffixArray = str_split($secretWord);
	print_r($suffixArray);
	$count = count($suffixArray)-1;
	include '../../Encryptors/LetterDescriptor.php';
	for($cycle=0; $cycle<=$count; $cycle++)
	{
		foreach ($suffixDescriptor as $key => $value)
		{
			$pattern = "/{$suffixArray[$cycle]}/";
			if(preg_match($pattern,$value)==1){
				$suffixArray{$cycle} = $key;
			}
		}
	}
	$suffix = strrev(implode('',$suffixArray));
	var_dump($suffix);
	return $suffix;
}

//function that creates array codedFullFuncName=>decodedCoreFuncName
function functionDecoder(array $oldFuncName)
{
	foreach ($oldFuncName as $key => $value)
	{
		$oldCore = str_split($value);
		$count = count($oldCore)-1;
		for ($cycle=0;$cycle<=$count;$cycle++)
		{
			$letter[] = letterCoreDecoder($oldCore[$cycle]);
		}
	}
	print_r($letter);
}

function letterCoreDecoder($letter)
{
	include '../../Encryptors/LetterDescriptor.php';
	$count = count($descriptor)-1;
	for($cycle = 0; $cycle <= $count; $cycle++)
	{
		if($letter == $descriptor[$cycle]){
			$letter = $cycle;
			continue;
		}
	}
	return $letter;
}


?>
</pre>