<?hh // strict

namespace FredEmmott\HackRouter;

class UnknownRouterException extends InternalServerErrorException {
  public function __construct(
    private array<mixed> $fastRouteData,
    string $method,
    string $path,
  ) {
    parent::__construct(
      'Request routing error: '.var_export($fastRouteData, true),
      $method,
      $path,
    );
  }

  public function getFastRouteData(): array<mixed> {
    return $this->fastRouteData;
  }
}
