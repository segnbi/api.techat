<?php

namespace Api\Controller;

use Api\Model\User;
use Api\Response\HttpResponse;
use Api\Validation\PostValidation;

class Authentication
{
  public function login($uri) {
    $errors = PostValidation::check([
      'user_name' => ['required'],
      'user_password' => ['required', 'correct_to:user_name'],
    ]);

    if (count($errors) > 0) {
      $http_response = new HttpResponse(400, ['messages' => $errors, 'documentation_url' => '']);
      return $http_response->send();
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

    /** http response preparation */
    $verifyied_user = User::read($_POST['user_name']);
    unset($verifyied_user['user_password']);

    $http_response = new HttpResponse(
      200,
      $verifyied_user,
      [
        'auto_connetion' => $_POST['auto_connection'],
      ]
    );

    return $http_response->send();
  }
}