<?hh // strict

namespace FredEmmott\HackRouter;

abstract class URIPart {
  abstract public function toRegExp(): string;

  public static function string(string $s): URIPart {
    return new URIStaticPart($s);
  }
}

final class URIStaticPart extends URIPart {
  public function __construct(private string $part) {
  }

  public function toRegExp(): string {
    return preg_quote($this->part, '#');
  }
}
