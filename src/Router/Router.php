<?php

namespace Api\Router;

use Api\Request\Request;
use Api\Response\HttpResponse;

class Router
{
  /** @var string regular expression for valid ID on uri */
  private const ID = '[0-9]+';

  /** @var string regular expression for valid operation on uri */
  private const OPERATION = '[+-]1';

  /** @var string regular expression to allow all different uri */
  private const ANY = '.+';

  /**
   * @param array $routes array of valid routes pattern and their matching controller/method
   *              (e.g. 'GET /messages' => ['Api\Controller\Messages', 'read_all'])
   */
  public function __construct(private array $routes = [])
  {
  }

  /**
   * match http request to the right controller/method
   * 
   * @param Request $request http request
   */
  public function route(Request $request)
  {
    foreach ($this->routes as $route => $class_method) {
      $route = '#^' . str_replace([':id', '?', ':operation', ':any'], [self::ID, '\?', self::OPERATION, self::ANY], $route) . '$#';

      if (preg_match($route, $request->uri)) {
        $class = new $class_method[0]();
        $method = $class_method[1];
        return $class->$method($request);
      }
    }

    return HttpResponse::send(404, ['message' => 'not found', 'documentation_url' => '']);
  }
}
