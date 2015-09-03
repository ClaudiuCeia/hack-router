<?hh // strict

namespace FredEmmott\HackRouter;

use FredEmmott\DefinitionFinder\TreeParser;

class URIMap<Tbase as URIRoutable> {
  public function __construct(
    private string $root,
    private classname<Tbase> $base,
  ) {}

  public function generateRegexpMap(): Map<string, classname<Tbase>> {
    $map = Map { };

    foreach ($this->getClassNames() as $class) {
      foreach ($class::getURIs() as $parts) {
        $re = self::generateRegexpForParts($parts);
        $map[$re] = $class;
      }
    }

    return $map;
  }

  public function generateFastRouteMap(): Map<string, classname<Tbase>> {
    $map = Map { };

    foreach ($this->getClassNames() as $class) {
      foreach ($class::getURIs() as $parts) {
        $re = self::generateFastRouteStringForParts($parts);
        $map[$re] = $class;
      }
    }

    return $map;
  }

  public static function generateRegexpForParts(
    Iterable<URIPart> $parts,
  ): string {
    $re_parts = $parts->map(
      $part ==> $part->toRegExp()
    );
    return '#^/'.implode('/', $re_parts).'/?$#';
  }

  public static function generateFastRouteStringForParts(
    Iterable<URIPart> $parts,
  ): string {
    return '/'.implode('/', $parts->map($part ==> $part->toFastRoute()));
  }

  private function getClassNames(): Iterable<classname<Tbase>> {
    return TreeParser::FromPath($this->root)
      ->getClassNames()
      ->filter($class ==> {
        $rc = new \ReflectionClass($class);
        return
          $rc->isInstantiable()
          && $rc->isSubclassOf($this->base);
      })->map(
        function(string $name): classname<Tbase> {
          return /* UNSAFE_EXPR */ $name;
        }
      );
  }
}
