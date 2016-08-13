<pre>
<?php
function encryptor($text,$key)
{
	$mc_d = mcrypt_module_open(MCRYPT_BLOWFISH,'',MCRYPT_MODE_CFB,'');
	$iv_size = mcrypt_enc_get_iv_size($mc_d);
	$iv = mcrypt_create_iv($iv_size,MCRYPT_RAND);
	mcrypt_generic_init($mc_d,$key,$iv);
	$newValue = mcrypt_generic($mc_d,$text);
	$newValue = base64_encode($iv.$newValue);
	mcrypt_generic_deinit($mc_d);
	return $newValue;
}

$key = 123;
$text = 'pizdec';

$var1 = encryptor($text,$key);
$var2 = encryptor($text,$key);

if($var1 === $var2){
	echo "It is OK!";
}else{
	echo "We have problem";
}
var_dump($var1);
var_dump($var2);
?>
</pre>
