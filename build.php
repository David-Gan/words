<?php
$data = [];

$cate1thArr = [];
$cate2thArr = [];

function buildCate1thPage ($cate1th, $cate2thArr) {
	global $data;

	file_put_contents(
		__DIR__ . "/pages/{$cate1th}.md", 
		implode(
			' ',
			array_map(
				function ($cate2th) use ($data, $cate1th) { 
					$words = implode(
						' ',
						array_map(
							function ($word) { 
								return "[{$word}](http://dict.youdao.com/w/eng/{$word}/#keyfrom=dict2.index) ";
							},
							$data[$cate1th][$cate2th]
						)
					);

					return "### {$cate2th}\n$words\n";
				},
				$cate2thArr
			)
		)
	);
}

$txt = file_get_contents(__DIR__ . '/noun.txt');
$lines = explode("\n", $txt);
foreach ($lines as $line) {
	$line = trim($line);
	if (! $line) continue;

	if (strpos($line, ' ') === false) {
		if ($cate2thArr) {
			buildCate1thPage($cate1th, $cate2thArr);
		}

		$cate1thArr[] = $cate1th = $line;
		$data [$cate1th] = $cate2thArr = [];
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


	// file_put_contents(
	// 	__DIR__ . "/pages/{$cate1th}-{$cate2th}.md",
	// 	implode(
	// 		' ',
	// 		array_map(
	// 			function ($word) { return "[{$word}](http://dict.youdao.com/w/eng/{$word}/#keyfrom=dict2.index)"; },
	// 			$words
	// 		)
	// 	)
	// );
}

if ($cate2thArr) {
	buildCate1thPage($cate1th, $cate2thArr);
}



file_put_contents(
	__DIR__ . '/README.md', 
	implode(
		' ',
		array_map(
			function ($word) { return "[{$word}](./pages/{$word}.md)"; },
			$cate1thArr
		)
	)
);

// print_r($data);


