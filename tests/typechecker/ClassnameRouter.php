<?hh // strict

namespace FredEmmott\HackRouter\ClassnameTypecheckTest;

use FredEmmott\HackRouter\BaseRouter;

abstract class BaseController {}
abstract class ReadController extends BaseController {}
abstract class WriteController extends BaseController {}

abstract class ClassnameTypecheckTest extends BaseRouter<
  classname<BaseController>,
  classname<ReadController>,
  classname<WriteController>
> {}
