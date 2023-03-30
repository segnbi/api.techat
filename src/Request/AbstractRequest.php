<?php

namespace Api\Request;

abstract class AbstractRequest extends Request
{
  protected array $content = [];
  abstract public function get_content(): array;
}