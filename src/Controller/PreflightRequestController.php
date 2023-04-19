<?php

namespace Api\Controller;

use Api\Request\Request;
use Api\Response\HttpResponse;

class PreflightRequestController
{
  public function option(Request $request)
  {
    return HttpResponse::send(200, ['messages' => 'preflight request', 'documentation_url' => '']);
  }
}
