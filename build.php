<?php
$data = [];

$cate1thArr = [];
$cate2thArr = [];

$txt = file_get_contents(__DIR__ . '/noun.txt');
$lines = explode("\n", $txt);
foreach ($lines as $line) {
	$line = trim($line);
	if (! $line) continue;

	if (strpos($line, ' ') === false) {
		if ($cate2thArr) {
			file_put_contents(
				__DIR__ . "/pages/{$cate1th}.md", 
				implode(
					' ',
					array_map(
						function ($word) { return "[{$word}](/pages/{$cate1th}-{$word}.md)"; },
						$cate2thArr
					)
				)
			);
		}

		$cate1thArr[] = $cate1th = $line;
		$data [$cate1th] = [];
		continue;
	}

	$words = explode(' ', $line);
	if (preg_match("/^[a-zA-Z]+$/", $words[0])) {
		$cate2th = $words [0];
	} else {
		$cate2th = array_shift($words);
	}

	$cate2thArr [] = $cate2th;
	$data [$cate1th] [$cate2th] = $words;


	file_put_contents(
		__DIR__ . "/pages/{$cate1th}-{$cate2th}.md",
		implode(
			' ',
			array_map(
				function ($word) { return "[{$word}](http://dict.youdao.com/w/eng/{$word}/#keyfrom=dict2.index)"; },
				$words
			)
		)
	);
}



file_put_contents(
	__DIR__ . '/README.md', 
	implode(
		' ',
		array_map(
			function ($word) { return "[{$word}](/pages/{$word}.md)"; },
			$cate1thArr
		)
	)
);

print_r($data);


