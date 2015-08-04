<?hh // strict

namespace FredEmmott\HackRouter;

abstract class URIPart {
  abstract public function toRegExp(): string;

  public static function staticPart(string $s): URIPart {
    return new URIStaticPart($s);
  }

  public static function s(string $s): URIPart {
    return self::staticPart($s);
  }
}
