<?php

namespace Api\Controller;

use Api\Model\User;
use Api\Response\HttpResponse;
use Api\Validation\PostValidation;


class Users
{
  public function create(string $uri)
  {
    $errors = PostValidation::check([
      'user_name' => ['required', 'valid_char:username', 'unused'],
      'user_password' => ['required', 'min_char:8'],
      'user_image' => ['allowed_file:jpg,jpeg,png,svg,webp', 'max_size:500']
    ]);

    if (count($errors) > 0) {
      $http_response = new HttpResponse(400, ['messages' => $errors, 'documentation_url' => '']);
      return $http_response->send();
    }

    $created_user = User::create($_POST['user_name'], $_POST['user_password'], $_FILES['user_image'] ?? '');

    $http_response = new HttpResponse(
      201,
      $created_user,
      ['login_url' => 'http://localhost:8080/credentiels']
    );

    return $http_response->send();
  }
}
