<?php
$config = [
	'account' => [
		'username' => 'admin',
		'password' => 'admin'
	]
];

@ include(__DIR__ . '/config.php');

$lifetime = 60 * 60 * 48;
ini_set("session.cookie_lifetime", $lifetime);
session_set_cookie_params($lifetime);
session_start();
setcookie(session_name(), session_id(), time() + $lifetime);

$action = & $_GET['action'];

$isLogin = ! empty($_SESSION['user']);
if (! $isLogin) {
	if ($action === 'login' && $_POST === $config['account']) {
		$_SESSION['user'] = 'ganmu';
		header("Location:/");
		exit();
	} else {
		view('login');
	}
}

$sentencesFile = __DIR__ . '/data/sentences.txt';
$wordsFile = __DIR__ . '/data/words.txt';

switch ($action) {
	case 'edit-words':
		$content = file_exists($wordsFile) ? file_get_contents($wordsFile) : '';
		view('edit', ['content' => $content, 'action' => 'update-words']);
		break;
	case 'edit-sentences':
		$content = file_exists($sentencesFile) ? file_get_contents($sentencesFile) : '';
		view('edit', ['content' => $content, 'action' => 'update-sentences']);
		break;
	case 'update-words':
		$content = & $_POST['content'];
		file_put_contents($wordsFile, $content);
		break;
	case 'update-sentences':
		$content = & $_POST['content'];
		file_put_contents($sentencesFile, $content);
		break;
	case 'words':
		$data = file_exists($wordsFile) ? file_get_contents($wordsFile) : '';
		view('show', ['data' => $data, 'action' => 'edit-words']);
		break;
	case 'sentences':
		$data = file_exists($sentencesFile) ? file_get_contents($sentencesFile) : '';
		view('show', ['data' => $data, 'action' => 'edit-sentences']);
		break;
	default:
		header("Location:/?action=sentences");
		break;
}

function view ($tpl, $_data = []) {
	extract($_data, EXTR_SKIP);

	ob_start();
	require __DIR__ . '/views/' . $tpl . '.php';
	$content = ob_get_clean();

	$jsFile = __DIR__ . '/views/' . $tpl . '.js';
	$js = file_exists($jsFile) ? file_get_contents($jsFile) : '';

	require __DIR__ . '/views/layout.php';
	die();
}

function isUrl ($text) {
	return in_array(strtolower(substr($text, 0, 6)), ['http:/', 'https:']);
}