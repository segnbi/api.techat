<?php

namespace Api\Controller;

use Api\Model\User;
use Api\Request\Request;
use Api\Request\FormRequest;
use Api\Response\HttpResponse;
use Api\Validator\PostValidator;

class AuthController
{
  public function login(Request $request) {
    $errors = PostValidator::check([
      'user_name' => ['required'],
      'user_password' => ['required', 'correct_to:user_name'],
    ], new FormRequest($request->uri));

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

    return HttpResponse::send(
      200,
      $current_user,
      ['auto_connetion' => $_POST['auto_connection']]
    );
  }
}