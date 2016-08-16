<?php

$value = '/*fHDh+kd9ymnX2wEvIdDpCx+4lhG4T/wSr5t6QdpM*/';
$secretWord = 12345;
$value = commentDecoder($value,$secretWord);
print_r($value);

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