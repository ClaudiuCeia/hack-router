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

abstract class HTTPException extends \Exception {
  public function __construct(
    string $message,
    private string $requestMethod,
    private string $requestedPath,
  ) {
    parent::__construct($message);
  }

  public function getRequestMethod(): string {
    return $this->requestMethod;
  }

  public function getRequestedPath(): string {
    return $this->requestedPath;
  }
}
