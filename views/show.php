<?php
$url = 'https://translate.google.cn/#view=home&op=translate&sl=en&tl=zh-CN&text=';
$content = '';
$lines = explode("\n", $data);
foreach ($lines as $line) {
	$line = trim($line);
	if (empty($line)) continue;

	if (substr($line, 0, 1) === '-') {
		$line = substr($line, 1);
		$line = trim($line);
		$content .= '<p><a class="source" target="_blank" href="' . $line . '">' . $line . '</a></p>';
	} else {
		$words = array_map(function ($word) {
			$url = 'https://dict.eudic.net/mdicts/en/' . $word;
			return '<a href="' . $url . '">' . $word . '</a>';
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