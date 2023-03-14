<?php

namespace Api\Response;

class HttpResponse {
  /**
   * @param int $code refer to an http response code (e.g. 404)
   * @param array $body refer to the http response body, should be an associative array or object
   * @param array $others additional information to append to the body, should be an associative array or object
   */
  public function __construct(private int $code, private array $body = [], private array $others = []) {}

  public function send() {
    foreach($this->others as $key => $value) {
      $this->body[$key] = $value;
    }

    http_response_code($this->code);
    echo json_encode($this->body, JSON_UNESCAPED_SLASHES);
  }
}