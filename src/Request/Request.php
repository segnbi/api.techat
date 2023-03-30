<?php

namespace Api\Request;

class Request
{
  public function __construct(public string $uri)
  {}
}