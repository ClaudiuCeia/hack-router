<?hh // strict

namespace FredEmmott\HackRouter\Tests;

use FredEmmott\HackRouter\GETOnlyRouter;

final class TestRouter<T> extends GETOnlyRouter<T> {
  public function __construct(
    private ImmMap<string, T> $routes,
  ) {
  }

  protected function getGETRoutes(): ImmMap<string, T> {
    return $this->routes;
  }
}
