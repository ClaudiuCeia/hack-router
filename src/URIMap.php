<?hh // strict

namespace FredEmmott\HackRouter;

class URIMap {
  public function __construct(private string $root) {}

  public function generate(): Map<string, string> {
    $map = Map { };
    $classes = (new \FredEmmott\DefinitionFinder\TreeWalker($this->root))
      ->getClasses()
      ->keys();
    $classes = $classes
      ->filter($class ==> {
        $rc = new \ReflectionClass($class);
        return
          $rc->isInstantiable()
          && $rc->implementsInterface(URIRoutable::class);
      });
    foreach ($classes as $class) {
      // UNSAFE because Hack doesn't understand that $class is a subclass
      // of URIRoutable
      $re_parts = $class::getURIParts()->map(
        $part ==> $part->toRegExp()
      );
      $re = '#^/'.implode('/', $re_parts).'/?$#';
      $map[$re] = (string) $class;
    }
    return $map;
  }
}
