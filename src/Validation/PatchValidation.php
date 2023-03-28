<?php

namespace Api\Validation;

class PatchValidation
{
  protected static array $errors = [];

  public static function check(array $field_rules, AbstractRequest $request_type): array
  {
    foreach ($request_type->get_content() as $key => $value) {
      $GLOBALS['_PATCH'][$key] = $value;
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
    $_PATCH = $GLOBALS['_PATCH'];

    if (empty($_PATCH[$field]) || !isset($_PATCH[$field])) {
      self::$errors[$field] = 'required';
    }
  }
}
