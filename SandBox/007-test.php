<pre>
<?php
$code = "var r = 15; function(r,vardx){r=vardx;return r;};";
var_dump($code);
$oldVar = 'r';
$newVar = 'newVarName';
$replacer = [
	"/var $oldVar /"=>"var $newVar",
	"/var $oldVar;/"=>"var $newVar;",
	"/var $oldVar=/"=>"var $newVar =",

	"/\($oldVar /"=>"($newVar ",
	"/\($oldVar,/"=>"($newVar,",
	"/\($oldVar=/"=>"($newVar =",
	
	"/ $oldVar\)/"=>" $newVar)",
	"/ ,$oldVar\)/"=>", $newVar)",
	 
	 "/\{$oldVar /"=>"\{$newVar ",
	 "/\{$oldVar,/"=>"\{$newVar,",
	 "/\{$oldVar=/"=>"\{$newVar =",

	"/ $oldVar\}/"=>" $newVar\}",
	"/ ,$oldVar\}/"=>", $newVar\}",
	
	"/ $oldVar;/"=>" $newVar;",
	"/=$oldVar;/"=>"= $newVar;",
	"/,$oldVar;/"=>", $newVar;",
	
	"/ $oldVar /"=>" $newVar ",
	"/,$oldVar,/"=>", $newVar,",
	"/ $oldVar=/"=>" $newVar = ",
	"/,$oldVar=/"=>", $newVar = ",
];

$count = count($replacer);
foreach ($replacer as $key=>$value){
	$code = preg_replace($key,$value,$code);
}
var_dump($code);
?>
</pre>
	