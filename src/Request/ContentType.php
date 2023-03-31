<?php

namespace Api\Request;

abstract class ContentType
{
  /**
   * @var array $content contains request content
   */
  protected array $content = [];

  /**
   * get request content
   * 
   * @return array $content
   */
  abstract public function get_content(): array;
}