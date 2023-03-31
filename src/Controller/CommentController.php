<?php

namespace Api\Controller;

use Api\Model\User;
use Api\Model\Comment;
use Api\Request\Request;
use Api\Model\CommentScored;
use Api\Response\HttpResponse;

class CommentController
{
  public function read_all(Request $request)
  {
    session_start();
    if (!isset($_SESSION['user_name'])) {
      return HttpResponse::send(401, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $current_user = User::read($_SESSION['user_name']);
    unset($current_user['user_password'], $current_user['id']);
    $response['current_user'] = $current_user;

    $comments = array_map(function ($comment) {
      $comment['user'] = '';
      $comment['replies'] = [];
      foreach (User::read_all() as $user) {
        if ($comment['user_id'] == $user['id']) {
          unset($user['id']);
          $comment['user'] = $user;
        }
      }
      unset($comment['user_id']);
      return $comment;
    }, Comment::read_all_comments());

    $replies = array_map(function ($reply) {
      $reply['replying_to'] = '';
      $reply['user'] = '';
      foreach (User::read_all() as $user) {
        if ($reply['user_id'] == $user['id']) {
          unset($user['id']);
          $reply['user'] = $user;
        }
      }
      unset($reply['user_id']);
      return $reply;
    }, Comment::read_all_replies());

    $response['comments'] = array_map(function ($comment) use ($replies) {
      foreach ($replies as $reply) {
        if ($reply['replying_to_comment'] == $comment['id']) {
          $reply['replying_to'] = $comment['user']['user_name'];
          unset($reply['replying_to_comment']);
          array_push($comment['replies'], $reply);
        }
        foreach ($comment['replies'] as $comment_reply) {
          if (isset($reply['replying_to_comment']) && $comment_reply['id'] == $reply['replying_to_comment']) {
            $reply['replying_to'] = $comment_reply['user']['user_name'];
            unset($reply['replying_to_comment']);
            array_push($comment['replies'], $reply);
          }
        }
      }
      return $comment;
    }, $comments);

    return HttpResponse::send(200, $response);
  }

  public function create(Request $request)
  {
    session_start();
    if (!isset($_SESSION['user_name'])) {
      return HttpResponse::send(401, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $errors = $request->check([
      'content' => ['required']
    ]);

    if (count($errors) > 0) {
      return HttpResponse::send(400, ['messages' => $errors, 'documentation_url' => '']);
    }

    $created_comment = Comment::create($_POST['content'], $_SESSION['user_id']);

    unset($created_comment['replying_to_comment']);

    return HttpResponse::send(
      201,
      $created_comment
    );
  }

  public function create_reply(Request $request)
  {
    session_start();
    if (!isset($_SESSION['user_name'])) {
      return HttpResponse::send(401, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $replied_comment_id = explode('=', $request->uri)[1];
    $replied_comment = Comment::read($replied_comment_id);

    if (!$replied_comment) {
      return HttpResponse::send(404, ['messages' => 'not found', 'documentation_url' => '']);
    }

    if ($replied_comment['user_id'] == $_SESSION['user_id']) {
      return HttpResponse::send(403, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $errors = $request->check([
      'content' => ['required'],
    ]);

    if (count($errors) > 0) {
      return HttpResponse::send(400, ['messages' => $errors, 'documentation_url' => '']);
    }

    $created_reply = Comment::create($_POST['content'], $_SESSION['user_id'], $replied_comment_id);

    unset($created_reply['user_id']);

    return HttpResponse::send(
      201,
      $created_reply
    );
  }

  public function update_content(Request $request)
  {
    session_start();
    if (!isset($_SESSION['user_name'])) {
      return HttpResponse::send(401, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $comment_id = explode('/', $request->uri)[2];
    $comment = Comment::read($comment_id);

    if (!$comment) {
      return HttpResponse::send(404, ['messages' => 'not found', 'documentation_url' => '']);
    }

    if ($_SESSION['user_id'] != $comment['user_id']) {
      return HttpResponse::send(403, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $errors = $request->check([
      'content' => ['required']
    ]);
    
    if (count($errors) > 0) {
      return HttpResponse::send(400, ['messages' => $errors, 'documentation_url' => '']);
    }

    $_PATCH = $GLOBALS['_PATCH'];

    $updated_comment = Comment::update($_PATCH['content'], $comment_id);

    unset($updated_comment['user_id'], $updated_comment['replying_to_comment']);

    return HttpResponse::send(
      201,
      $updated_comment
    );
  }

  public function delete(Request $request)
  {
    session_start();
    if (!isset($_SESSION['user_name'])) {
      return HttpResponse::send(401, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $comment_id = explode('/', $request->uri)[2];
    $comment = Comment::read($comment_id);

    if (!$comment) {
      return HttpResponse::send(404, ['messages' => 'not found', 'documentation_url' => '']);
    }

    if ($_SESSION['user_id'] != $comment['user_id']) {
      return HttpResponse::send(403, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $replies = Comment::read_all_replies();

    foreach($replies as $reply) {
      if($reply['replying_to_comment'] == $comment['id']) {
        return HttpResponse::send(403, ['messages' => 'not found', 'documentation_url' => '']);
      }
    }

    Comment::delete($comment_id);

    return HttpResponse::send(204);
  }

  public function update_score(Request $request)
  {
    session_start();

    if (!isset($_SESSION['user_name'])) {
      return HttpResponse::send(401, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $uri = str_replace(['?', '='], ['/', '/'], $request->uri);

    $comment_id = explode('/', $uri)[2];
    $operation = explode('/', $uri)[4];

    $comment = Comment::read($comment_id);

    if (!$comment) {
      return HttpResponse::send(404, ['messages' => 'not found', 'documentation_url' => '']);
    }

    $comment_scored = CommentScored::read($comment_id, $_SESSION['user_id']);

    if (!$comment_scored && $operation == '+1') {
      CommentScored::create($comment_id, $_SESSION['user_id']);
      $comment = Comment::update_score(++$comment['score'], $comment_id);

      unset($comment['user_id']);
      
      return HttpResponse::send(200, $comment);
    }
    
    if ($comment_scored && $operation == '-1') {
      CommentScored::delete($comment_id, $_SESSION['user_id']);
      $comment = Comment::update_score(--$comment['score'], $comment_id);
      
      unset($comment['user_id']);

      return HttpResponse::send(200, $comment);
    }

    return HttpResponse::send(403, ['messages' => 'not found', 'documentation_url' => '']);
  }
}
