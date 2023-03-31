<?php

namespace Api\Request;

class FormContent extends ContentType
{
  public function get_content(): array{
    if(count($_POST) > 0) {
      return $this->content;
    }
  }
}