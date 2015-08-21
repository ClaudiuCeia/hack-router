<?hh // strict

namespace FredEmmott\HackRouter;

final class URIIntParam extends URIParam {
  protected function getPattern(): string {
    return "\d+";
  }
}
