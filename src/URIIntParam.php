<?hh // strict

namespace FredEmmott\HackRouter;

final class URIIntParam extends URIParam {
  public function getPattern(): string {
    return "\d+";
  }
}
