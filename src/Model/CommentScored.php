<?php

namespace Api\Model;

use Api\Database\Database;

class CommentScored
{
  public static function read(int $comment_id, int $user_id)
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('SELECT * FROM comment_scored WHERE comment_id = :comment_id AND user_id = :user_id');
    $pdo_statement->execute([
      'comment_id' => $comment_id,
      'user_id' => $user_id
    ]);

    return $pdo_statement->fetch();
  }

  public static function create(int $comment_id, int $user_id)
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('INSERT INTO comment_scored (comment_id, user_id) VALUES (:comment_id, :user_id)');
    $pdo_statement->execute([
      'comment_id' => $comment_id,
      'user_id' => $user_id
    ]);

    $pdo_statement = $pdo->query('SELECT * FROM comments WHERE id = ' . $comment_id);

    return $pdo_statement->fetch();
  }

  public static function delete(int $comment_id, int $user_id)
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('DELETE FROM comment_scored WHERE comment_id = :comment_id AND user_id = :user_id');
    $pdo_statement->execute([
      'comment_id' => $comment_id,
      'user_id' => $user_id
    ]);

    $pdo_statement = $pdo->query('SELECT * FROM comments WHERE id = ' . $comment_id);

    return $pdo_statement->fetch();
  }
}
