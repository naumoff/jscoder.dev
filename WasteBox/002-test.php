<?php
//to put code to array we insert delimiter for each string
//as a glue that splits elements in array
$pattern = '*/';
$replacer = '*/ PHP_EOL';
$code = str_replace($pattern,$replacer,$code);
$pattern = ';';
$replacer = '; PHP_EOL';
$code = str_replace($pattern,$replacer,$code);
//var_dump($code);

//convert code to array
$codeArray = explode('PHP_EOL',$code);
$count = count($codeArray)-1;
$cycle = 0;
print_r($codeArray);

for($cycle = 0; $cycle<=$count; $cycle++)
{
	// comments decoding part
	$pattern = '/\/\*(.+)\*\//';
	if(preg_match($pattern,$codeArray[$cycle])==1){
		$codeArray[$cycle] = commentDecoder($codeArray[$cycle],$secretWord);
		continue;
	}
	
	// function decoding part;
	
}

print_r($codeArray);