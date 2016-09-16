<?hh // strict

namespace FredEmmott\HackRouter\Tests;

use FredEmmott\HackRouter\BaseRouter;
use FredEmmott\HackRouter\HttpMethod;

final class TestRouter<T> extends BaseRouter<T> {
  public function __construct(
    private ImmMap<string, T> $routes,
  ) {
  }

  <<__Override>>
  protected function getRoutes(
  ): ImmMap<HttpMethod, ImmMap<string, T>> {
    return ImmMap {
      HttpMethod::GET => $this->routes,
    };
  }
}
