<?php
$config = [
	'account' => [
		'username' => 'admin',
		'password' => 'admin'
	]
];

@ include(__DIR__ . '/config.php');

$lifetime = 60 * 60 * 48;
session_set_cookie_params($lifetime);
session_start(); 
setcookie(session_name(), session_id(), time() + $lifetime);

$action = & $_GET['action'];

$isLogin = ! empty($_SESSION['user']);
if (! $isLogin) {
	if ($action === 'login' && $_POST === $config['account']) {
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