<?hh // strict

namespace FredEmmott\HackRouter;

final class URIStringParam extends URIParam {
  public function getPattern(): string {
    return "[^/]+";
  }
}
