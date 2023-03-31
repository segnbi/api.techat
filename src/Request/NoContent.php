<?php

namespace Api\Request;

class NoContent extends ContentType
{
  public function get_content(): array
  {
    return $this->content;
  }
}
