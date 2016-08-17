<pre>
<?php
$string = 'newObject';
$text = str_split($string);
foreach ($text as $value)
{
	$newValue[] = coderName($value);
}

print_r($newValue);

function coderName($value)
{
	include '../Encryptors/LetterDescriptor.php';
	foreach ($descriptor as $key=>$oldValue)
	{
		if($value === $oldValue){
			$newVar = $key;
		}
	}
	return $newVar;
}