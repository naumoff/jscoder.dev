<pre>
<?php
$myArray = [1,2,3,3,4,5,1];
print_r($myArray);
$myArray = array_unique($myArray);
$myArray = array_keys($myArray);
print_r($myArray);