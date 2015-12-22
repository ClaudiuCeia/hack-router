<?hh // strict
/*
 *  Copyright (c) 2015, Facebook, Inc.
 *  Copyright (c) 2015, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 *
 */

namespace FredEmmott\HackRouter;

class NotFoundException extends HTTPException {
  public function __construct(string $method, string $path) {
    parent::__construct(
      "Not Found: ".$path,
      $method,
      $path,
    );
  }
}