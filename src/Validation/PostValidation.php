<?php

namespace Api\Validation;

use Api\Model\User;

class PostValidation
{
  /** @var array $errors caching all errors from post/file field checking */
  private static array $errors = [];

  /**
   * call defined rules corresponding method for each right post/file field
   * 
   * @param array $field_rules each post/file field with their validation rules
   * @return array with all errors @see PostValidation::$errors
   */
  public static function check(array $field_rules): array
  {
    $option = '';

    foreach ($field_rules as $field => $rules) {
      foreach ($rules as $rule) {
        if (str_contains($rule, ':')) {
          $rule_option = explode(':', $rule);
          $rule = $rule_option[0];
          $option = $rule_option[1];
        }

        self::$rule($field, $option);
      }
    }

    return self::$errors;
  }

  private static function required(string $field, $option)
  {
    if (empty($_POST[$field]) || !isset($_POST[$field])) {
      self::$errors[$field] = 'required';
    }
  }

  private static function unused(string $field, $option)
  {
    if (empty(self::$errors[$field]) && isset($_POST[$field]) && User::read($_POST[$field])) {
      self::$errors[$field] = 'user already exist';
    }
  }

  private static function min_char(string $field, int $option)
  {
    if (isset($_POST[$field]) && !preg_match('#^.{' . $option . ',}$#', $_POST[$field]) && empty(self::$errors[$field])) {
      self::$errors[$field] = 'this field must contain atleast ' . $option . ' character';
    }
  }

  private static function max_size(string $field, int $option)
  {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
      if ($_FILES[$field]['size'] > ($option * 1000) && empty(self::$errors[$field])) {
        self::$errors[$field] = 'file must be less than ' . $option . 'ko.';
      }
    }
  }

  private static function allowed_file(string $field, string $option)
  {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
      $files_allowed = explode(',', $option);
      $file_extension = pathinfo($_FILES[$field]['name'])['extension'];

      if (!in_array($file_extension, $files_allowed) && empty(self::$errors[$field])) {
        self::$errors[$field] = 'file must be one of these type: ' . implode(', ', $files_allowed) . '.';
      }
    }
  }

  private static function valid_char(string $field, $option)
  {
    if (
      empty(self::$errors[$field]) &&
      isset($_POST[$field]) &&
      $option == 'username' &&
      !preg_match('#^[a-zA-Z0-9_]+$#', $_POST[$field])
    ) {
      self::$errors[$field] = $option .' can only contain letters(a-z), numbers(0-9) and (_)';
    }
  }
}
