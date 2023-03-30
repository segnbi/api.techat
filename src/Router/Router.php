<?php
namespace Api\Router;

use Api\Request\Request;
use Api\Response\HttpResponse;

class Router
{
  /** @var string regular expression string for valid identifier on routes */
  private const ID = '[0-9]+';

  /** @var string regular expression string for valid operation on routes */
  private const OPERATION = '[+-]1';

  /** @var string regular expression string to escape question mark(?) on routes */
  private const OPTION = '\?';

  /** @var string regular expression string to escape question mark(?) on routes */
  private const USERNAME = '[a-zA-Z0-9_]+';

  /**
   * @param array $routes an array of valid routes pattern and their matching controller/method
   *              (e.g. 'PATCH /messages/:id?score=:operation' => ['Api\Controller\Messages', 'update_score'])
   * @return void
   */
  public function __construct(private array $routes = [])
  {}

  /**
   * match upcoming http request to the right controller/method
   * 
   * @param Request $request refer to the upcoming http request e.g. " new Request('POST /users') "
   * @return void
   */
  public function route(Request $request)
  {
    foreach ($this->routes as $route => $class_method) {
      $route = '#^' . str_replace([':id', '?', ':operation', ':username'], [self::ID, self::OPTION, self::OPERATION, self::USERNAME], $route) . '$#';

      if(preg_match($route, $request->uri)) {
        $class = new $class_method[0]();
        $method = $class_method[1];
        return $class->$method($request);
      }
    }

    return HttpResponse::send(404, ['message' => 'not found', 'documentation_url' => '']);
  }
}
