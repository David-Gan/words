<?php
$url = 'https://translate.google.cn/#view=home&op=translate&sl=en&tl=zh-CN&text=';
$content = '';
$lines = explode("\n", $data);
foreach ($lines as $line) {
	$line = trim($line);
	if (empty($line)) continue;

	if (substr($line, 0, 1) === '-') {
		$line = substr($line, 1);
		$content .= '<p><a class="source" target="_blank" href="' . $line . '">' . $line . '</a></p>';
	} else {
		$content .= '<p><a href="' . $url . urlencode($line) . '">' . $line . '</a></p>';	
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
</style>
<div class="container" style="margin-top:20px;">
	<p style="text-align: right;"><a href="/?action=edit">EDIT</a></p>
	<?=$content?>
</div>