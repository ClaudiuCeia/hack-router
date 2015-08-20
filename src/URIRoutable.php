<?hh // strict

namespace FredEmmott\HackRouter;

interface URIRoutable {
  public static function getURIParts(): \ConstVector<URIPart>;
}
