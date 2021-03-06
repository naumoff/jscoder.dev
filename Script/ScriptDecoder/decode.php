<?php
session_start();
$secretWord = $_SESSION['secret_word'];
$funcEncryptStatus = $_SESSION['function_encrypt'];
$varEncryptStatus = $_SESSION['variable_encrypt'];
$fakeInsertStatus = $_SESSION['fake_data'];
$newFilePath = $_SESSION['newFilePath'];

// open downloaded decoded file and assign its content to $code string variable
$handle = fopen($newFilePath,'r');
$code = fread($handle,filesize($newFilePath));

//decoding comments part
$pattern = '/\/\*.+?\*\//';
preg_match_all($pattern,$code,$matches);
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
	$mode = 1; // this mode ads 'func' word before prefix
	$prefix = prefixDecoder($secretWord,$mode);
	
	//retrieved coded suffix of funcName
	$suffix = suffixDecoder($secretWord);
	
	//retrieved coded core name of funcName
	$pattern = "/$prefix(?P<funcName>.+?)$suffix/";
	preg_match_all($pattern,$code,$matches);
	$oldCoreFuncName = array_unique($matches['funcName']);
	
	//retrieved array codedFullFuncName=>codedCoreFuncName
	foreach ($oldCoreFuncName as $key=>$value)
	{
		$oldFuncName[$prefix.$oldCoreFuncName[$key].$suffix] = $oldCoreFuncName[$key];
	}
	
	//retrieved array codedFullFuncName=>decodedCoreFuncName
	$decodedFuncNameArray = Decoder($oldFuncName);
	
	//replaced in $code old coded funcNames to decoded funcNames
	foreach($decodedFuncNameArray as $key=>$value)
	{
		$code = str_replace($key,$value,$code);
	}
}

//decoding variable names
if($varEncryptStatus ==1){
	//to avoid duplicate code suffixDecoder used for variable prefixes
	$prefixVar = 'vardom'.strrev(suffixDecoder($secretWord));
	
	//to avoid duplicate code prefixDecoder used for variable suffixes
	$mode = 0; // this mode abolishes 'func' word adding and does strrev()
	$suffixVar = prefixDecoder($secretWord,$mode);
	
	//created array fullCodedVariableName=>coreCodedVariableName
	$pattern = "/{$prefixVar}(?P<varCore>.+?){$suffixVar}/";
	preg_match_all($pattern,$code,$matches);
	$matches = array_unique($matches['varCore']);
	foreach ($matches as $value)
	{
		$codedVarArray[$prefixVar.$value.$suffixVar] = $value;
	}
	
	//create array fullCodedVariableName=>coreDecodedVariableName
	$decodedVariableNameArray = Decoder($codedVarArray);
	
	//replaced old coded variable names with decoded names
	foreach ($decodedVariableNameArray as $key=>$value)
	{
		$code = str_replace($key,$value,$code);
	}
}

//removed fake data from script
if($fakeInsertStatus == 1){
	$code = fakeDataRemoval($code);
	//removed duplicate ';;'
	$pattern = '/;[;]+/';
	$replacer = ';';
	$code = preg_replace($pattern,$replacer,$code);
}

//split one string into lines
$code = str_replace(';',';PHP_EOL',$code);
$code = str_replace('*/','*/PHP_EOL',$code);
$code = str_replace('{ ','{PHP_EOL ',$code);
$code = explode('PHP_EOL',$code);

//create new JS file with decoded content
$decodedFilePath = '../../Data/JS-decoded/js_decoded.js';
$handle = fopen($decodedFilePath,'w');
foreach ($code as $string)
{
	$string = $string."\n";
	fwrite($handle,$string);
}

$_SESSION['complete'] = 2;
header('Location: ../../index.php');
exit;

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
function prefixDecoder($secretWord,$mode)
{
	$prefixArray = str_split($secretWord);
	$count = count($prefixArray)-1;
	include '../../Encryptors/LetterDescriptor.php';
	for($cycle=0; $cycle<=$count; $cycle++)
	{
		$pattern = "/{$prefixArray[$cycle]}/";
		foreach ($prefixDescriptor as $key => $value)
		{
			if(preg_match($pattern,$value)){
				$prefixArray{$cycle} = $key;
			}
		}
	}
	if($mode==1){
		$prefix = 'func'.implode('',$prefixArray);
	}elseif($mode==0){
		$prefix = strrev(implode('',$prefixArray));
	}

	return $prefix;
}

// function that detects suffix of coded function
function suffixDecoder($secretWord)
{
	$suffixArray = str_split($secretWord);
	$count = count($suffixArray)-1;
	include '../../Encryptors/LetterDescriptor.php';
	for($cycle=0; $cycle<=$count; $cycle++)
	{
		$pattern = "/{$suffixArray[$cycle]}/";
		foreach ($suffixDescriptor as $key => $value)
		{
			if(preg_match($pattern,$value)){
				$suffixArray{$cycle} = $key;
			}
		}
	}
	$suffix = strrev(implode('',$suffixArray));
	return $suffix;
}

//function that creates array codedFullFuncName=>decodedCoreFuncName
function Decoder(array $oldFuncName)
{
	foreach ($oldFuncName as $CodedFullName => $codedCoreName)
	{
		$codedCore = str_split($codedCoreName);
		$count = count($codedCore)-1;
		for ($cycle=0;$cycle<=$count;$cycle++)
		{
			$decodedCore[] = letterCoreDecoder($codedCore[$cycle]);
		}
		$decodedCoreName = implode('',$decodedCore);
		$newFuncName[$CodedFullName] = $decodedCoreName;
		unset($decodedCore);
	}
	return $newFuncName;
}

function letterCoreDecoder($letter)
{
	include '../../Encryptors/LetterDescriptor.php';
	foreach ($descriptor as $key => $oldValue)
	{
		$pattern = "/{$letter}/";
		$text = "{$key}";
		if(preg_match($pattern,$text)){
			$newValue = $oldValue;
		}
	}
	return $newValue;
}

//function that removes fake data from script
function fakeDataRemoval($code)
{
	include '../../Encryptors/JS-functions.php';
	foreach ($fakeFunc as $value)
	{
		$code = str_replace($value,'',$code);
	}
	return $code;
}
