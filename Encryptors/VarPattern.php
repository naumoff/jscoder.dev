<?php
// this variable contains patterns and replacements for variable names
$varReplacer = [
	"/var $oldVar /"=>"var $newVar ",
	"/var $oldVar;/"=>"var $newVar;",
	"/var $oldVar=/"=>"var $newVar=",
	"/var $oldVar =/"=>"var $newVar =",
	
	"/\($oldVar /"=>"($newVar ",
	"/\($oldVar,/"=>"($newVar,",
	"/\($oldVar=/"=>"($newVar=",
	
	"/ $oldVar\)/"=>" $newVar)",
	"/,$oldVar\)/"=>",$newVar)",
	
	"/\{{$oldVar} /"=>"{{$newVar} ",
	"/\{{$oldVar},/"=>"{{$newVar},",
	"/\{{$oldVar}=/"=>"{{$newVar}=",
	
	"/ $oldVar\}/"=>" $newVar}",
	"/ ,$oldVar\}/"=>" ,$newVar}",
	
	"/ $oldVar;/"=>" $newVar;",
	"/=$oldVar;/"=>"=$newVar;",
	"/,$oldVar;/"=>",$newVar;",
	
	"/ $oldVar /"=>" $newVar ",
	"/,$oldVar,/"=>",$newVar,",
	"/ $oldVar=/"=>" $newVar=",
	"/,$oldVar=/"=>",$newVar=",
];