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
      $re_parts = $class::getURIParts()->map(
        $part ==> $part->toRegExp()
      );
      $re = '#^/'.implode('/', $re_parts).'/?$#';
      $map[$re] = $class;
    }
    return $map;
  }
}
