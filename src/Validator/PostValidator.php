<?php

namespace Api\Validator;

use Api\Model\User;

class PostValidator extends RequestValidator
{
  public static function check(array $field_rules, array $request_content = []): array
  {
    foreach($request_content as $key => $value) {
      $_POST[$key] = $value;
    }

    $parameter = '';

    foreach ($field_rules as $field => $rules) {
      foreach ($rules as $rule) {
        if (str_contains($rule, ':')) {
          $rule_parameter = explode(':', $rule);
          $rule = $rule_parameter[0];
          $parameter = $rule_parameter[1];
        }

        self::$rule($field, $parameter);
      }
    }

    return self::$errors;
  }

  private static function required(string $field)
  {
    if (empty($_POST[$field]) || !isset($_POST[$field])) {
      self::$errors[$field] = 'required';
    }
  }

  private static function unused(string $field)
  {
    if (empty(self::$errors[$field]) && isset($_POST[$field]) && User::read($_POST[$field])) {
      self::$errors[$field] = 'user already exist';
    }
  }

  private static function min_char(string $field, int $parameter)
  {
    if (isset($_POST[$field]) && !preg_match('#^.{' . $parameter . ',}$#', $_POST[$field]) && empty(self::$errors[$field])) {
      self::$errors[$field] = 'this field must contain atleast ' . $parameter . ' character';
    }
  }

  private static function valid_char(string $field, $parameter)
  {
    if (
      empty(self::$errors[$field]) &&
      isset($_POST[$field]) &&
      $parameter == 'username' &&
      !preg_match('#^[a-zA-Z0-9_]+$#', $_POST[$field])
    ) {
      self::$errors[$field] = $parameter . 'must contain valid character.';
    }
  }

  private static function correct_to(string $password_field, string $user_name_field)
  {
    if (
      !empty(self::$errors[$password_field]) ||
      !empty(self::$errors[$user_name_field]) ||
      !isset($_POST[$password_field]) ||
      !isset($_POST[$user_name_field])
    ) {
      return null;
    }

    $user = User::read($_POST[$user_name_field]);

    if(!$user || !password_verify($_POST[$password_field], $user['user_password'])) {
      self::$errors[$password_field] = 'invalid username or password';
      self::$errors[$user_name_field] = 'invalid username or password';
    }
  }

  private static function max_size(string $field, int $parameter)
  {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
      if ($_FILES[$field]['size'] > ($parameter * 1000) && empty(self::$errors[$field])) {
        self::$errors[$field] = 'file must be less than ' . $parameter . 'ko.';
      }
    }
  }

  private static function allowed_file(string $field, string $parameter)
  {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
      $files_allowed = explode(',', $parameter);
      $file_extension = pathinfo($_FILES[$field]['name'])['extension'];

      if (!in_array($file_extension, $files_allowed) && empty(self::$errors[$field])) {
        self::$errors[$field] = 'file must be one of these type: ' . implode(', ', $files_allowed) . '.';
      }
    }
  }
}
