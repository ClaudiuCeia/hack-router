<?hh //strict
/*
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

namespace FredEmmott\HackRouter;

abstract class TypedUriParameter<T>
extends UriParameter
implements TypedRequestParameter<T> {
  public function getUriFragment(T $value): string {
    return (string) $value;
  }
}
