<?php

namespace Api\Validation;

class FormRequest extends AbstractRequest
{
  public function get_content(): array{
    if(count($_POST) > 0) {
      return [];
    }
  }
}