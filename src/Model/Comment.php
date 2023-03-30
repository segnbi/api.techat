<?php

namespace Api\Model;

use Api\Database\Database;

class Comment
{
  public static function create(string $content, int $user_id, int|NULL $replying_to_comment = NULL)
  {
    $content = strip_tags($content);

    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('INSERT INTO comments(content, created_at, user_id, replying_to_comment) VALUES (:content, NOW(), :user_id, :replying_to_comment)');
    $pdo_statement->execute([
      'content' => $content,
      'user_id' => $user_id,
      'replying_to_comment' => $replying_to_comment
    ]);

    $pdo_statement = $pdo->query('SELECT * FROM comments WHERE id = LAST_INSERT_ID()');

    return $pdo_statement->fetch();
  }

  public static function update(string $content, int $comment_id)
  {
    $content = strip_tags($content);

    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('UPDATE comments SET content = :content WHERE id = :comment_id');
    $pdo_statement->execute([
      'content' => $content,
      'comment_id' => $comment_id
    ]);

    $pdo_statement = $pdo->query('SELECT * FROM comments WHERE id = ' . $comment_id);

    return $pdo_statement->fetch();
  }

  public static function delete(int $comment_id)
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('DELETE FROM comments WHERE id = :comment_id');
    $pdo_statement->execute([
      'comment_id' => $comment_id
    ]);

    return $pdo_statement->fetch();
  }

  public static function update_score(string $score, int $comment_id)
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('UPDATE comments SET score = :score WHERE id = :comment_id');
    $pdo_statement->execute([
      'score' => $score,
      'comment_id' => $comment_id
    ]);

    $pdo_statement = $pdo->query('SELECT * FROM comments WHERE id = ' . $comment_id);

    return $pdo_statement->fetch();
  }

  public static function read(int $comment_id)
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->prepare('SELECT * FROM comments WHERE id = :comment_id');
    $pdo_statement->execute([
      'comment_id' => $comment_id
    ]);

    return $pdo_statement->fetch();
  }

  public static function read_all_comments()
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->query(
      'SELECT id, content, created_at, score, user_id
       FROM comments
       WHERE replying_to_comment IS NULL
       ORDER BY created_at'
    );

    return $pdo_statement->fetchAll();
  }

  public static function read_all_replies()
  {
    $pdo = Database::connect();

    $pdo_statement = $pdo->query(
      'SELECT id, content, created_at, score, user_id, replying_to_comment
       FROM comments
       WHERE replying_to_comment IS NOT NULL
       ORDER BY created_at'
    );

    return $pdo_statement->fetchAll();
  }
}
