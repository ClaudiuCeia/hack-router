<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

abstract class RequestParameter implements UriPatternPart {
  /** Convert to T or throw an exception if failed. */
  abstract public function assert(string $input): mixed;

  public function __construct(
    private string $name,
  ) {
  }

  final public function getName(): string {
    return $this->name;
  }
}
