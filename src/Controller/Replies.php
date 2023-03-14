<?php

namespace Api\Controller;

use Api\Response\HttpResponse;

class Replies {
  public function update_score(string $uri) {
    $http_response = new HttpResponse(200, ['message' => $uri]);
    return $http_response->send();
  }
}