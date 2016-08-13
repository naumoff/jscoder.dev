<pre>
<?php
$myArray = [
	1,2,3,3,4,5,1
];
var_dump($myArray);
$myArray = array_unique($myArray);
$myArray = array_keys($myArray);
var_dump($myArray);

// ******************************

$superArray = [0=>1,3=>2,5=>10];
print_r($superArray);
$superArray = array_values($superArray);
print_r($superArray);