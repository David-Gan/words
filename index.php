<?php
session_start();
$action = & $_GET['action'];

$isLogin = ! empty($_SESSION['user']);
if (! $isLogin) {
	$token = [
		'username' => 'ganmu',
		'password' => '13311221'
	];

	if ($action === 'login' && $_POST === $token) {
		$_SESSION['user'] = 'ganmu';
	} else {
		view('login');
	}
}

$dataFile = __DIR__ . '/data.txt';
switch ($action) {
	case 'edit':
		$content = file_exists($dataFile) ? file_get_contents($dataFile) : '';
		view('edit', ['content' => $content]);
		break;
	case 'update':
		$content = & $_POST['content'];
		file_put_contents($dataFile, $content);
		break;
	default:
		$data = file_exists($dataFile) ? file_get_contents($dataFile) : '';
		view('show', ['data' => $data]);
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