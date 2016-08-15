<pre>
<?php
include_once '../Encryptors/JS-functions.php';
$count = count($fakeFunc)-1;
$quantity = rand(0,5);

for ($x = 0; $x<$quantity; $x++){
	$key = rand(0,$count);
	$result[] = ($fakeFunc[$key]);
}

$result = implode('',$result);




?>
</pre>
	
	