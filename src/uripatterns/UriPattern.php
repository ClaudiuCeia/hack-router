<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

// Non-final so you can extend it with additional convenience
// methods.
class UriPattern implements UriPatternPart {
  private Vector<UriPatternPart> $parts = Vector { };

  final public function appendPart(UriPatternPart $part): this {
    if ($part instanceof UriPattern) {
      $this->parts->addAll($part->parts);
      return $this;
    }
    
    $this->parts[] = $part;
    return $this;
  }

  final public function getFastRouteFragment(): string {
    $fragments = $this->parts->map(
      $part ==> $part->getFastRouteFragment()
    );
    return implode('', $fragments);
  }

  ///// Convenience Methods /////

  final public function literal(string $part): this {
    return $this->appendPart(new UriPatternLiteral($part));
  }

  final public function string(string $name): this {
    return $this->appendPart(new UriPatternStringParameter($name));
  }

  final public function int(string $name): this {
    return $this->appendPart(new UriPatternIntParameter($name));
  }

  final public function enum<T>(
    /* HH_FIXME[2053] \HH\BuiltinEnum is an implementation detail */
    classname<\HH\BuiltinEnum<T>> $enum_class,
    string $name,
  ): this {
    return $this->appendPart(
      new UriPatternEnumParameter($enum_class, $name),
    );
  }
}