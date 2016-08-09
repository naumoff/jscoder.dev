<?php
$FilePathOld = '../JS-old/js_old.js';
$FilePathNew = '../JS-new/js_new.js';
$handleOld = fopen($FilePathOld,'r');
$handleNew = fopen($FilePathNew,'w+');
$count = 0;
WHILE($string = fgets($handleOld)){
	$string = changeComments($string);
	$str[]=$string;
	$count ++;
	if ($count >=20){
		writeToFile($str,$handleNew);
		$count = 0;
		$str = null;
	}
}
writeToFile($str,$handleNew);

// functions to code existing JS

//function that transform comments
function changeComments(&$string)
{
	$pattern = '/(\/\/)(.+)$/';
	$replacer = '/* \2 */';
	$string = preg_replace($pattern,$replacer,$string);
	return $string;
}


// function that cut new lines
function writeToFile($str,$handleNew)
{
	$code = implode(" ",$str);
	$code = str_replace("\n"," ",$code);
	$code = str_replace("\r"," ",$code);
	print_r($code);
	fwrite($handleNew,$code);
}




