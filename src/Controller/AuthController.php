<?php

namespace Api\Controller;

use Api\Model\User;
use Api\Response\HttpResponse;
use Api\Validation\FormRequest;
use Api\Validation\PostValidation;

class AuthController
{
  public function login($uri) {
    $errors = PostValidation::check([
      'user_name' => ['required'],
      'user_password' => ['required', 'correct_to:user_name'],
    ], new FormRequest);

    if (count($errors) > 0) {
      return HttpResponse::send(400, ['messages' => $errors, 'documentation_url' => '']);
    }

    if(isset($_POST['auto_connection'])) {
      session_set_cookie_params([
        'lifetime' => 31536000
      ]);
    } else {
      $_POST['auto_connection'] = '';
    }
    session_start();
    $_SESSION['user_name'] = $_POST['user_name'];

    $current_user = User::read($_POST['user_name']);
    unset($current_user['user_password']);

    return HttpResponse::send(
      200,
      $current_user,
      ['auto_connetion' => $_POST['auto_connection']]
    );
  }
}