<?php

namespace Api\Response;

class HttpResponse {
  /**
   * @param int $code refer to an http response code (e.g. 404)
   * @param array $body refer to the http response body, should be an associative array or object
   * @param array $others additional information to append to the body, should be an associative array or object
   */
  public static function send(int $code, array $body = [], array $others = []) {
    foreach($others as $key => $value) {
      $body[$key] = $value;
    }

    http_response_code($code);
    echo json_encode($body, JSON_UNESCAPED_SLASHES);
  }
}