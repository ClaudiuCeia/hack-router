<?hh // strict

namespace FredEmmott\HackRouter;

class UnknownRouterException extends \Exception {
  public function __construct(
    private array<mixed> $fastRouteData,
  ) {
    parent::__construct(
      'Unknown FastRoute response: '.var_export($fastRouteData, true),
    );
  }

  public function getFastRouteData(): array<mixed> {
    return $this->fastRouteData;
  }
}
