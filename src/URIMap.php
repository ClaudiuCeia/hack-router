<?hh // strict

namespace FredEmmott\HackRouter;

use FredEmmott\DefinitionFinder\TreeParser;

class URIMap<Tbase as URIRoutable> {
  public function __construct(
    private string $root,
    private classname<Tbase> $base,
  ) {}

  public function generate(): Map<string, classname<Tbase>> {
    $map = Map { };
    $classes = TreeParser::FromPath($this->root)
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

    foreach ($classes as $class) {
      $re = self::generateForParts($class::getURIParts());
      $map[$re] = $class;
    }
    return $map;
  }

  public static function generateForParts(
    \ConstVector<URIPart> $parts,
  ): string {
    $re_parts = $parts->map(
      $part ==> $part->toRegExp()
    );
    return '#^/'.implode('/', $re_parts).'/?$#';
  }
}
