<?php

namespace Api\Validation;

class JsonRequest extends AbstractRequest
{
  private array $content = [];

  public function get_content(): array {
    $json_data = json_decode(file_get_contents('php://input'));
    foreach ($json_data as $key => $value) {
      $this->content[$key] = $value;
    }

    return $this->content;
  } 
}