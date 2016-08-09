<pre>
<?php
$subject = '/* this is comment one */ var x = "Hello, "; var y = "see our World!"; /* this is comment three */ /* this is comment four comment continuation comment closing */ document.write(x,y);';
$pattern = '/\/\*[^\*\/]+\*\//';
preg_match_all($pattern, $subject, $matches);
print_r($matches);
?>
</pre>
	