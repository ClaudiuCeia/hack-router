<?hh //strict
/*
 *  Copyright (c) 2016, Fred Emmott
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree.
 */

 namespace FredEmmott\HackRouter;

 enum RouterExceptionType: string {
   NOT_FOUND = 'not found';
   METHOD_NOT_ALLOWED = 'method not allowed';
 }
