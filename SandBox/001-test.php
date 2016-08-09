<?php
function changeComments(&$string)
{
	$pattern = '/\/\/(.+)/';
	$replacer = '/* \1 */';
	$string = preg_replace($pattern,$replacer,$string);

}

$string = '// this is comment ones';
changeComments($string);
print_r($string);