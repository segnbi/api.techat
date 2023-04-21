<?php

namespace Api\Request;

use Api\Validator\PostValidator;
use Api\Validator\PatchValidator;
use Api\Validator\RequestValidator;

class Request
{
  public string $uri;
  private ContentType $content_type;
  private RequestValidator $request_validator;

  /**
   * @param string $verb http verb e.g. GET
   * @param string $uri e.g. /comments
   */
  public function __construct(string $verb, string $uri)
  {
    $this->uri = $verb . ' ' . $uri;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->request_validator = new PostValidator();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
      $this->request_validator = new PatchValidator();
    }

    if (!isset($_SERVER['CONTENT_TYPE'])) {
      return $this->content_type = new NoContent();
    }

    if (str_contains($_SERVER['CONTENT_TYPE'], 'form-data')) {
      $this->content_type = new FormContent();
    }

    if (str_contains($_SERVER['CONTENT_TYPE'], 'json')) {
      $this->content_type = new JsonContent();
    }
  }

  /**
   * init fields checking
   * 
   * @param array $field_rules associative array with each field and its validation rules
   */
  public function check(array $field_rules): array
  {
    $request_content = $this->content_type->get_content();
    return $this->request_validator->check($field_rules, $request_content);
  }
}
