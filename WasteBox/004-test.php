<pre>
<?php
$oldFuncName =
[
	'funcm87vtRrX7xUry8Xq7TS' => 'RrX7xUry8',
	'funcm87vtx1XxR61nXq7TS' => 'x1XxR61n',
	'funcm87vtTnMTR6nMXq7TS' => 'TnMTR6nM',
	'funcm87vtsTnR6sTnsTXq7TS' => 'sTnR6sTnsT'
];

print_r($oldFuncName);

foreach ($oldFuncName as $oldFullName=>$oldCoreName)
{
	echo $oldCoreName."\n";
	$newCoreName[$oldFullName] = coreNameDecoder($oldCoreName);
}

print_r($newcoreName); // не работает

function coreNameDecoder($oldCoreName)
{
	//$oldCoreName = funcName in one word
	$codedLetters = str_split($oldCoreName);
	foreach ($codedLetters as $codedOneLetter)
	{
		$decodedLetters[] = letterDecoder($codedOneLetter);
	}
	
	$decodedValue = implode('',$decodedLetters);
	print_r($decodedValue);
	return $decodedValue;
}

function letterDecoder($codedOneLetter)
{
	include '../Encryptors/LetterDescriptor.php';
	foreach ($descriptor as $key=>$oldValue)
	{
		if($codedOneLetter == $key){
			$decodedOneLetter = $oldValue;
		}
	}
	return $decodedOneLetter;
}

?>
</pre>
	