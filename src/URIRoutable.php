<?hh // strict

namespace FredEmmott\HackRouter;

interface URIRoutable {
  public static function getURIs(): Iterable<Iterable<URIPart>>;
}
