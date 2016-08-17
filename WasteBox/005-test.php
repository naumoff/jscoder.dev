<pre>
<?php

$string = 'BCX7xUCif';

$stringArray = str_split($string);

print_r($stringArray);

include '../Encryptors/LetterDescriptor.php';
$count = count($descriptor)-1;
//print_r($descriptor);

foreach ($stringArray as $value)
{
	foreach($descriptor as $key=>$oldValue)
	{
		$pattern = "/{$value}/";
		$text = "{$key}";
		if(preg_match($pattern,$text)){
			$newValue = $oldValue;
		}
	}
	$decoded[]=$newValue;
}

print_r($decoded);

echo "<hr>";