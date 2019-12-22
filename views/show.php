<?php
$url = 'https://translate.google.cn/#view=home&op=translate&sl=en&tl=zh-CN&text=';
$content = '';
$lines = explode("\n", $data);
foreach ($lines as $line) {
	$line = trim($line);
	if (empty($line)) continue;

	if (in_array(strtolower(substr($line, 0, 6)), ['http:/', 'https:'])) {
		$line = trim($line);
		$content .= '<p><a class="source" target="_blank" href="' . $line . '">' . $line . '</a></p>';
	} else {
		$words = array_map(function ($text) {
			list($startChars, $word, $endChars) = explode(' ', preg_replace('/(\W*)(\w+)(\W*)$/', '${1} ${2} ${3}', $text));
			$url = 'https://dict.eudic.net/mdicts/en/' . $word;
			return $startChars . '<a href="' . $url . '">' . $word . '</a>' . $endChars;
		}, explode(' ', $line));

		$sentence = '<a class="sentence" href="' . $url . urlencode($line) . '">-S</a>';

		$content .= '<p>' . implode(' ', $words) . ' ' . $sentence . '</p>';	
	}
}
?>
<style type="text/css">
	.container a {
		color: black;
	}
	.container .source {
		color: #aaa;
	}
	.container .sentence {
		color: #aaa;
		margin-left: 0.5rem;
	}
</style>
<div class="container" style="margin-top:20px;">
	<p style="text-align: right;"><a href="/?action=edit">EDIT</a></p>
	<?=$content?>
</div>