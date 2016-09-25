<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

final class IntRequestParameter
extends TypedUriParameter<int> {
  <<__Override>>
  public function assert(string $input): int {
    invariant(
      ctype_digit($input),
      '`%s` is not a valid int',
      $input,
    );
    return (int) $input;
  }

  <<__Override>>
  public function getRegExpFragment(): ?string {
    return '\d+';
  }
}
