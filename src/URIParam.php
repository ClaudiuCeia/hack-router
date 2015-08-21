<?hh // strict

namespace FredEmmott\HackRouter;

abstract class URIParam extends URIPart {
  public static function int(string $name): URIPart {
    return new URIIntParam($name);
  }

  public static function string(string $name): URIPart {
    return new URIStringParam($name);
  }

  public static function enum(string $name, Iterable<string> $values): URIPart {
    return new URIEnumParam($name, $values);
  }

  public function __construct(
    private string $name,
  ) {
  }

  final public function toRegExp(): string {
    return '(?<'.preg_quote($this->getName(), '#').'>'.$this->getPattern().')';
  }

  abstract protected function getPattern(): string;

  final public function getName(): string {
    return $this->name;
  }
}
