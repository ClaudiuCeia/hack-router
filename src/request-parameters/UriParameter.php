<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

abstract class UriParameter extends RequestParameter {
  abstract public function getRegExpFragment(): ?string;

  final public function getFastRouteFragment(): string {
    $name = $this->getName();
    $re = $this->getRegExpFragment();
    if ($re === null) {
      return '{'.$name.'}';
    }
    return '{'.$name.':'.$re.'}';
  }
}
