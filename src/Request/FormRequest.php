<?php

namespace Api\Request;

class FormRequest extends AbstractRequest
{
  public function __construct(public string $uri)
  {}

  public function get_content(): array{
    if(count($_POST) > 0) {
      return [];
    }
  }
}