<?hh // strict

namespace FredEmmott\HackRouter;

abstract class URIParam extends URIPart {
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
