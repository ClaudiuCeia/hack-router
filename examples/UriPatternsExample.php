<?hh
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

/***********
 * IF YOU EDIT THIS FILE also update the snippet in README.md
 ***********/

namespace FredEmmott\HackRouter\Examples\UrlPatternsExample;

require_once('../vendor/autoload.php');

use FredEmmott\HackRouter\BaseRouter;
use FredEmmott\HackRouter\HttpMethod;
use FredEmmott\HackRouter\UriBuilder;
use FredEmmott\HackRouter\UriPattern;
use FredEmmott\HackRouter\UriParameters;

<<__ConsistentConstruct>>
abstract class WebController {
  abstract public function getResponse(): string;
  abstract public static function getUriPattern(): UriPattern;

  final public static function getUriBuilder(): UriBuilder {
    return (new UriBuilder(static::getUriPattern()->getParts()));
  }

  private UriParameters $uriParameters;
  final protected function getUriParameters(): UriParameters {
    return $this->uriParameters;
  }

  public function __construct(
    ImmMap<string, string> $uri_parameter_values,
  ) {
    $this->uriParameters = new UriParameters(
      static::getUriPattern()->getParameters(),
      $uri_parameter_values,
    );
  }
}

final class HomePageController extends WebController {
  public static function getUriPattern(): UriPattern {
    return (new UriPattern())->literal('/');
  }

  public function getResponse(): string {
    return 'Hello, world';
  }
}

final class UserPageController extends WebController {
  public static function getUriPattern(): UriPattern {
    return (new UriPattern())
      ->literal('/users/')
      ->string('user_name');
  }

  public function getResponse(): string {
    return 'Hello, '.$this->getUriParameters()->getString('user_name');
  }
}

type TResponder = classname<WebController>;

final class UriPatternsExample extends BaseRouter<TResponder> {
  public static function getControllers(): ImmVector<TResponder> {
    return ImmVector {
      HomePageController::class,
      UserPageController::class,
    };
  }

  <<__Override>>
  public function getRoutes(
  ): ImmMap<HttpMethod, ImmMap<string, TResponder>> {
    $urls_to_controllers = Map { };
    foreach (self::getControllers() as $controller) {
      $pattern = $controller::getUriPattern();
      $urls_to_controllers[$pattern->getFastRouteFragment()] = $controller;
    }
    return ImmMap {
      HttpMethod::GET => $urls_to_controllers->immutable(),
    };
  }
}

function get_example_paths(): ImmVector<string> {
  return ImmVector {
    HomePageController::getUriBuilder()->getPath(),
    UserPageController::getUriBuilder()
      ->setString('user_name', 'Mr Hankey')
      ->getPath(),
  };
}

function main(): void {
  $router = new UriPatternsExample();
  foreach (get_example_paths() as $path) {
    list($controller, $params) = $router->routeRequest(
      HttpMethod::GET,
      $path,
    );
    printf(
      "GET %s\n\t%s\n",
      $path,
      (new $controller($params))->getResponse(),
    );
  }
}

main();
