<pre>
<?php
$array = [1,2,3,4,5];
rsort($array);
print_r($array);

$array = [0=>1,1=>2,2=>3,3=>4,4=>5];
$count = count($array);
$key = 0;

for($count; $count==0; $count--){
	$arrayReverse[$key] = $array[$count];
	$key++;
}

var_dump($arrayReverse);
?>
</pre>