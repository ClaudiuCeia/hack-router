<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

/* This interface exists as subclasses can not redefine abstract
 * methods as abstract but with a different signature; interfaces can.
 *
 * Do not use this in code - you should be able to use
 * TypedRequestParameter instead.
 *
 * This will hopefully be removed at some point:
 *  https://github.com/facebook/hhvm/issues/7352
 */
interface ITypedRequestParameter_INTERNAL<T> {
  require extends RequestParameter;
  public function assert(string $value): T;
}

abstract class TypedRequestParameter<T>
extends RequestParameter
implements ITypedRequestParameter_INTERNAL<T> {
  public function getUriFragment(T $value): string {
    return (string) $value;
  }
}
