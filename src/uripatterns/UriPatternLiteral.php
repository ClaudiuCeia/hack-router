<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

final class UriPatternLiteral implements UriPatternPart {
  public function __construct(private string $value) {
  }

  public function getFastRouteFragment(): string {
    $value = $this->value;
    // No escaping required :)
    invariant(
      strpos($value, '{') === false,
      '{ is not valid in a URI - see nikic/FastRoute#6',
    );
    return $value;
  }

  public function getValue(): string {
    return $this->value;
  }
}
