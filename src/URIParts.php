<?hh // strict

namespace FredEmmott\HackRouter;

final class URIStaticPart extends URIPart {
  public function __construct(private string $part) {
  }

  public function toRegExp(): string {
    return preg_quote($this->part, '#');
  }
}

final class URIIntParam extends URIParam {
  protected static function getPattern(): string {
    return "\d+";
  }
}
