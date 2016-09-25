<?hh // strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

trait RequestParameterGetters {
  require extends RequestParametersBase;

  final public function getString(string $name): string {
    return $this->getSimpleTyped(StringRequestParameter::class, $name);
  }

  final public function getInt(string $name): int {
    return $this->getSimpleTyped(IntRequestParameter::class, $name);
  }

  final public function getEnum<TValue>(
    /* HH_FIXME[2053] */
    classname<\HH\BuiltinEnum<TValue>> $class,
    string $name,
  ): TValue {
    $spec = $this->getSpec(
      EnumRequestParameter::class,
      $name,
    );
    invariant(
      $spec->getEnumName() === $class,
      'Expected %s to be a %s, actually a %s',
      $name,
      $class,
      $spec->getEnumName(),
    );
    return $spec->assert($this->values->at($name));
  }
}
