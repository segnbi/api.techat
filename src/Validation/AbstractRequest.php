<?php

namespace Api\Validation;

abstract class AbstractRequest
{
  abstract public function get_content(): array;
}