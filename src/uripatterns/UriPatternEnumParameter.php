<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

/* HH_FIXME[2053] BuiltinEnum is dark internal magic :p */
class UriPatternEnumParameter<TBase as arraykey, T as \HH\BuiltinEnum<T>>
extends UriPatternParameter<T> {
  public function __construct(
    private classname<T> $enumClass,
    string $name,
  ) {
    parent::__construct($name);
  }


  <<__Override>>
  public function assert(string $input): T {
    $class = $this->enumClass;
    return $class::assert($input);
  }

  <<__Override>>
  public function getRegExpFragment(): ?string {
    $class = $this->enumClass;
    $values = (new ImmVector($class::getValues()));
    $sub_fragments = $values->map($value ==> preg_quote($value));
    return '(?:'.implode('|', $sub_fragments).')';
  }
}
