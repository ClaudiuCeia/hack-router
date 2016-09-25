<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

class EnumRequestParameter<T>
extends TypedRequestParameter<T> {
  public function __construct(
    /* HH_FIXME[2053] */
    private classname<\HH\BuiltinEnum<T>> $enumClass,
    string $name,
  ) {
    parent::__construct($name);
  }

  /* HH_FIXME[2053] */
  final public function getEnumName(): classname<\HH\BuiltinEnum<T>> {
    return $this->enumClass;
  }

  <<__Override>>
  final public function getUriFragment(T $value): string {
    $class = $this->enumClass;
    return (string) $class::assert($value);
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
