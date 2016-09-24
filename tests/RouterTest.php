<?hh // strict

namespace FredEmmott\HackRouter;

use \FredEmmott\HackRouter\Tests\TestRouter;
use \Zend\Diactoros\ServerRequest;

final class CoreTest extends \PHPUnit_Framework_TestCase {
  public function expectedMatches(
  ): array<(string, string, ImmMap<string, string>)> {
    return [
      tuple('/foo', 'root file', ImmMap {}),
      tuple('/foo/', 'root dir', ImmMap {}),
      tuple('/foo/bar', 'subfile', ImmMap {}),
      tuple('/foo/herp', 'param subfile', ImmMap { 'bar' => 'herp'}),
    ];
  }

  /**
   * @dataProvider expectedMatches
   */
  public function testMatchesPattern(
    string $in,
    string $expected_responder,
    ImmMap<string, string> $expected_data,
  ): void {
    list($actual_responder, $actual_data) =
      $this->getRouter()->routeRequest(HttpMethod::GET, $in);
    $this->assertSame($expected_responder, $actual_responder);
    $this->assertEquals(
      $expected_data->toArray(),
      $actual_data->toArray(),
    );
  }

  /**
   * @dataProvider expectedMatches
   */
  public function testPsr7Support(
    string $path,
    string $_expected_responder,
    ImmMap<string, string> $_expected_data,
  ): void {
    $router = $this->getRouter();
    list($direct_responder, $direct_data) = $router->routeRequest(
      HttpMethod::GET,
      $path,
    );

    /* HH_FIXME[2049] no HHI for Diactoros */
    $psr_request = new ServerRequest(
      /* server = */ [],
      /* file = */ [],
      'http://example.com/'.$path,
      'GET',
      /* body = */ '/dev/null',
      /* headers = */ [],
    );
    list($psr_responder, $psr_data) = $router->routePsr7Request($psr_request);
    $this->assertSame(
      $direct_responder,
      $psr_responder,
    );
    $this->assertEquals(
      $direct_data,
      $psr_data,
    );
  }

  /**
   * @expectedException \FredEmmott\HackRouter\NotFoundException
   */
  public function testNotFound(): void {
    $this->getRouter()->routeRequest(HttpMethod::GET, '/__404');
  }

  /**
   * @expectedException \FredEmmott\HackRouter\MethodNotAllowedException
   */
  public function testMethodNotAllowed(): void {
    $this->getRouter()->routeRequest(HttpMethod::POST, '/foo');
  }

  <<__Memoize>>
  private function getRouter(): TestRouter<string> {
    return new TestRouter(
      ImmMap {
        '/foo' => 'root file',
        '/foo/' => 'root dir',
        '/foo/bar' => 'subfile',
        '/foo/{bar}' => 'param subfile',
      },
    );
  }
}
