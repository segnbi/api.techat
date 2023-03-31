<?php

namespace Api\Controller;

use Api\Model\User;
use Api\Request\Request;
use Api\Response\HttpResponse;

class AuthController
{
  public function login(Request $request) {
    $errors = $request->check([
      'user_name' => ['required'],
      'user_password' => ['required', 'correct_to:user_name'],
    ]);

    if (count($errors) > 0) {
      return HttpResponse::send(400, ['messages' => $errors, 'documentation_url' => '']);
    }

    $current_user = User::read($_POST['user_name']);
    unset($current_user['user_password']);

    if(isset($_POST['auto_connection'])) {
      session_set_cookie_params([
        'lifetime' => 31536000
      ]);
    } else {
      $_POST['auto_connection'] = '';
    }
    session_start();
    $_SESSION['user_name'] = $_POST['user_name'];
    $_SESSION['user_id'] = $current_user['id'];

    $response = $current_user;

    $response['auto_connection'] = $_POST['auto_connection'];

    return HttpResponse::send(
      200,
      $response
    );
  }
}