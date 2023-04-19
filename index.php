<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'api-autoload.php';

use Api\Request\Request;
use Api\Router\Router;

$router = new Router([
  'POST /users' => ['Api\Controller\UserController', 'create'],
  'POST /authentication' => ['Api\Controller\AuthController', 'login'],
  'GET /comments' => ['Api\Controller\CommentController', 'read_all'],
  'POST /comments' => ['Api\Controller\CommentController', 'create'],
  'POST /comments?replying-to-comment=:id' => ['Api\Controller\CommentController', 'create_reply'],
  'PATCH /comments/:id' => ['Api\Controller\CommentController', 'update_content'],
  'PATCH /comments/:id?score=:operation' => ['Api\Controller\CommentController', 'update_score'],
  'DELETE /comments/:id' => ['Api\Controller\CommentController', 'delete'],
  'OPTIONS /:any' => ['Api\Controller\PreflightRequestController', 'enable']
]);

$router->route(new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']));
