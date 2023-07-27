<?php

namespace Api\Model;

use Api\Database\Database;

class User
{
  public static function create(string $user_name, string $user_password, array|string $user_image)
  {
    $image_path = 'public/images/default-image.png';
    $user_name = strip_tags($user_name);

    if (!empty($user_image) && $user_image['error'] == 0) {
      $image_extension = pathinfo($user_image['name'])['extension'];
      $image_path = 'public/images/' . $user_name . '-image.' . $image_extension;

      move_uploaded_file(
        $_FILES['user_image']['tmp_name'],
        $image_path
      );
    }

    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare(
      'INSERT INTO users(user_name, user_password, user_image)
       VALUES (:user_name, :user_password, :user_image)'
    );
    $pdo_statement->execute([
      'user_name' => $user_name,
      'user_password' => password_hash($user_password, PASSWORD_DEFAULT),
      'user_image' => 'http://localhost:8000/' . $image_path
    ]);

    $pdo_statement = $pdo->query('SELECT user_name, user_image FROM users WHERE id = LAST_INSERT_ID()');

    return $pdo_statement->fetch();
  }

  public static function read($user_name)
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('SELECT * FROM users WHERE user_name = :user_name');
    $pdo_statement->execute(['user_name' => $user_name]);

    return $pdo_statement->fetch();
  }

  public static function read_all()
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->query('SELECT id, user_name, user_image FROM users');

    return $pdo_statement->fetchAll();
  }
}
