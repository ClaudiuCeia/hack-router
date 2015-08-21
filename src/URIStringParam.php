<?hh // strict

namespace FredEmmott\HackRouter;

final class URIStringParam extends URIParam {
  protected function getPattern(): string {
    return "[^/]+";
  }
}
