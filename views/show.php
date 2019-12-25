<?php

$url = 'https://translate.google.cn/#view=home&op=translate&sl=en&tl=zh-CN&text=';
$content = '';
$lines = explode("\n", $data);
foreach ($lines as $line) {
	$line = trim($line);
	if (empty($line)) continue;

	if (isUrl($line)) {
		$line = trim($line);
		$content .= '<p><a class="source" target="_blank" href="' . $line . '">' . $line . '</a></p>';
	} elseif ($line === '-') {
		$content .= '<hr />';
	} else {
		$words = array_map(function ($text) {
			if (isUrl($text)) {
				return '<a target="_blank" href="' . $text . '">' . $text . '</a>';
			}

			$matches = [];
			$count = preg_match_all('/([a-z]+)/i', $text, $matches, PREG_OFFSET_CAPTURE);
			if (! $count) {
				return $text;
			}

			$matches = $matches[0];

			$html = '';
			$cursor = 0;
			while ($matches) {
				$match = array_shift($matches);
				list($word, $pos) = $match;
				if ($pos > $cursor) {
					$html .= substr($text, $cursor, $pos - $cursor);
				}

				if (strlen($word) > 1) {
					$url = 'https://dict.eudic.net/mdicts/en/' . $word;
					$html .= '<a href="' . $url . '">' . $word . '</a>';
				} else {
					$html .= $word;
				}

				$cursor = $pos + strlen($word);

				if (! $matches) {
					$html .= substr($text, $cursor);
				}
			}

			return $html;
		}, explode(' ', $line));

		$sentence = '<a class="sentence" href="' . $url . urlencode($line) . '">-S</a>';

		$content .= '<p>' . implode(' ', $words) . ' ' . $sentence . '</p>';	
	}
}
?>
<style type="text/css">
	#main a {
		color: black;
		word-break: break-word;
	}
	#main .source {
		background-color: gray;
		color: white;
	}
	#main .sentence {
		color: #aaa;
		margin-left: 0.5rem;
	}
</style>
<div class="container" id="main" style="margin-top:20px;">
	<p style="text-align: right;">
		<a href="/?action=<?=$action?>">Edit</a>
	</p>
	<?=$content?>
</div>