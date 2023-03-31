<?php

namespace Api\Controller;

use Api\Model\User;
use Api\Request\Request;
use Api\Response\HttpResponse;

class UserController
{
  public function create(Request $request)
  {
    $errors = $request->check([
      'user_name' => ['required', 'valid_char:username', 'unused'],
      'user_password' => ['required', 'min_char:8'],
      'user_image' => ['allowed_file:jpg,jpeg,png,svg,webp', 'max_size:500']
    ]);

    if (count($errors) > 0) {
      return HttpResponse::send(400, ['messages' => $errors, 'documentation_url' => '']);
    }

    $created_user = User::create($_POST['user_name'], $_POST['user_password'], $_FILES['user_image'] ?? '');

    return HttpResponse::send(201, $created_user);
  }
}
