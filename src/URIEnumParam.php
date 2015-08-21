<?hh // strict

namespace FredEmmott\HackRouter;

final class URIEnumParam extends URIParam {
  public function __construct(
    string $name,
    private Iterable<string> $values,
  ) {
    parent::__construct($name);
  }

  protected function getPattern(): string {
    $quoted = $this->values->map($v ==> preg_quote($v, '#'));
    return '('.implode('|', $quoted).')';
  }
}
