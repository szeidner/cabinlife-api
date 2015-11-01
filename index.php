<?php

// In case one is using PHP 5.4's built-in server
$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
	return false;
}

// Include the Router class
require_once __DIR__ . '/core/Router.php';

// Include configuration and models
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/model/Post.php';

// Create a Router
$router = new \Bramus\Router\Router();

// Custom 404 Handler
$router->set404(function () {
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	echo '404, route not found!';
});

// Before Router Middleware
$router->before('GET', '/.*', function () {
	header('Content-Type: application/json');
});

// // Static route: / (homepage)
// $router->get('/', function () {
// 	echo '';
// });

$router->mount('/post', function () use ($router) {

	// Route: /posts (fetch all posts)
	$router->get('/', function () {
		$postModel = new Posts();
		$posts = $postModel->getAllPosts();
		echo json_encode($posts);
	});

	// Route: /post/id (fetch a single post)
	$router->get('/(\d+)', function ($id) {
		$postModel = new Posts();
		$post = $postModel->getPost($id);
		echo json_encode($post);
	});
});

// Thunderbirds are go!
$router->run();

// EOF
