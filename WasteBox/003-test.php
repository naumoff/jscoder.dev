<pre>
<?php
$text = '/*wt/f1*/ blablabla /*wt/f2*/ blublublu /*wt/f3*/';
$pattern ='/\/\*.+?\*\//';
preg_match_all($pattern,$text,$matches);
print_r($matches);