<pre>
<?php
$key = 12345;
$text = 'HelloWorld';
$text = str_split($text);
print_r($text);

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
		if($value == $oldValue){
			$value = $key;
		}
	}
	return $value;
}
?>
</pre>
	