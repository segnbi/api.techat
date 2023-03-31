<?php

namespace Api\Validator;

abstract class RequestValidator
{
  public static array $errors = [];

  /**
   * match fields to their corresponding rules method
   * 
   * @param array $field_rules associative array with each fields and their validation rules
   * @param array $request_content array with the request contents
   * @return array $errors contains all invalidated request fields key with their errors
   */
  abstract public static function check(array $field_rules, array $request_content): array;
}
