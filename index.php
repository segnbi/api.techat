<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
// header("Access-Control-Allow-Credentials: true");

require_once 'spl-autoload.php';

use Api\Router\Router;

$router = new Router([
  'POST /users' => ['Api\Controller\Users', 'create'],
  'POST /authentication' => ['Api\Controller\Authentication', 'login'],
  'GET /messages/replies' => ['Api\Controller\Messages', 'read'],
  'POST /messages' => ['Api\Controller\Messages', 'create'],
  'PATCH /messages/' => ['Api\Controller\Messages', 'update_content'],
  'PATCH /messages/:id?score=:operation' => ['Api\Controller\Messages', 'update_score'],
  'DELETE /messages/' => ['Api\Controller\Messages', 'delete'],
  'POST /messages/:id/replies' => ['Api\Controller\Replies', 'create'],
  'PATCH /replies/' => ['Api\Controller\Replies', 'update_content'],
  'PATCH /replies/:id?score=:operation' => ['Api\Controller\Replies', 'update_score'],
  'DELETE /replies/' => ['Api\Controller\Replies', 'delete'],
]);

$router->route($_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);
