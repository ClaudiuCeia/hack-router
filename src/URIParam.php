<?hh // strict

namespace FredEmmott\HackRouter;

abstract class URIParam extends URIPart {
  public static function int(string $name): URIPart {
    return new URIIntParam($name);
  }

  public static function string(string $name): URIPart {
    return new URIStringParam($name);
  }

  public function __construct(
    private string $name,
  ) {
  }

  final public function toRegExp(): string {
    return '(?<'.preg_quote($this->getName(), '#').'>'.static::getPattern().')';
  }

  abstract protected static function getPattern(): string;

  final public function getName(): string {
    return $this->name;
  }
}

final class URIIntParam extends URIParam {
  protected static function getPattern(): string {
    return "\d+";
  }
}

final class URIStringParam extends URIParam {
  protected static function getPattern(): string {
    return "[^/]+";
  }
}
