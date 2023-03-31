<?php

namespace Api\Request;

use Api\Validator\PostValidator;
use Api\Validator\PatchValidator;
use Api\Validator\RequestValidator;

class Request
{
  public string $uri;
  public ContentType $content_type;
  public RequestValidator $request_validator;

  public function __construct(string $uri)
  {
    $this->uri = $_SERVER['REQUEST_METHOD'] . ' ' . $uri;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->request_validator = new PostValidator();
    }

    if($_SERVER['REQUEST_METHOD'] == 'PATCH') {
      $this->request_validator = new PatchValidator();
    }

    if(!isset($_SERVER['CONTENT_TYPE'])) {
      return $this->content_type = new NoContent();
    }

    if(str_contains($_SERVER['CONTENT_TYPE'], 'form-data')) {
      $this->content_type = new FormContent();
    }

    if(str_contains($_SERVER['CONTENT_TYPE'], 'json')) {
      $this->content_type = new JsonContent();
    }
  }

  public function check(array $field_rules): array
  {
    $request_content = $this->content_type->get_content();
    return $this->request_validator->check($field_rules, $request_content);
  }
}