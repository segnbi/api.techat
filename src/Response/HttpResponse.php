<?php

namespace Api\Response;

class HttpResponse
{
  /**
   * send an http response
   * 
   * @param int $code refer to an http response code (e.g. 404)
   * @param array $body refer to the http response body, should be an associative array
   */
  public static function send(int $code, array $body = [])
  {
    http_response_code($code);
    echo json_encode($body, JSON_UNESCAPED_SLASHES);
  }
}
