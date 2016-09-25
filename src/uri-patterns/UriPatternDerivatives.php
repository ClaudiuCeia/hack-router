<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

trait UriPatternDerivatives {
  require implements HasUriPattern;

  final public static function getUriBuilder(): UriBuilder {
    return (new UriBuilder(static::getUriPattern()->getParts()));
  }

  final public static function getFastRoutePattern(): string {
    return static::getUriPattern()->getFastRouteFragment();
  }
}
