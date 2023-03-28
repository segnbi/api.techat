<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'spl-autoload.php';

use Api\Router\Router;

$router = new Router([
  'POST /users' => ['Api\Controller\UserController', 'create'],
  'POST /authentication' => ['Api\Controller\AuthController', 'login'],
  'GET /comments' => ['Api\Controller\CommentController', 'read_all'],
  'POST /comments' => ['Api\Controller\CommentController', 'create'],
  'POST /comments?replying-to-comment=:id' => ['Api\Controller\CommentController', 'create_reply'],
  'PATCH /comments/:id' => ['Api\Controller\CommentController', 'update_content'],
  'PATCH /comments/:id?score=:operation' => ['Api\Controller\CommentController', 'update_score'],
  'DELETE /comments/:id' => ['Api\Controller\CommentController', 'delete']
]);

$router->route($_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);
