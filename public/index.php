<?php
// public/index.php
session_start();

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base = ($scriptDir === '/') ? '' : rtrim($scriptDir, '/');
$GLOBALS['base'] = $base;

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();

// مسارات الصفحة الرئيسية
$router->add('GET', '/', ['HomeController', 'index']);
$router->add('GET', '/about', ['HomeController', 'about']);

// مسارات المصادقة
$router->add('GET', '/register', ['AuthController', 'showRegister']);
$router->add('POST', '/register', ['AuthController', 'register']);
$router->add('GET', '/login', ['AuthController', 'showLogin']);
$router->add('POST', '/login', ['AuthController', 'login']);
$router->add('GET', '/logout', ['AuthController', 'logout']);

// مسارات معرض الصور وإدارتها
$router->add('GET', '/photos', ['PhotoController', 'index']);
$router->add('GET', '/photo/upload', ['PhotoController', 'create']);
$router->add('POST', '/photo/store', ['PhotoController', 'store']);
$router->add('GET', '/photos/{id}', ['PhotoController', 'show']);
$router->add('GET', '/photo/{id}', ['PhotoController', 'show']);

// مسارات الحذف
$router->add('POST', '/photo/{id}/delete', ['PhotoController', 'delete']);
$router->add('POST', '/photos/{id}/delete', ['PhotoController', 'delete']);
$router->add('POST', '/photo/delete', ['PhotoController', 'delete']);

// مسار التعليقات
$router->add('POST', '/comment/store', ['CommentController', 'store']);

// تشغيل الموجه
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);