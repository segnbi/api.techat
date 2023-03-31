<?php

namespace Api\Request;

class JsonContent extends ContentType
{
  public function get_content(): array {
    $json_data = json_decode(file_get_contents('php://input'));
    foreach ($json_data as $key => $value) {
      $this->content[$key] = $value;
    }

    return $this->content;
  } 
}