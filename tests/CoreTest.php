<?hh // strict

namespace FredEmmott\HackRouter;

use FredEmmott\HackRouter\Tests\TestRouter;

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
      $this->getRouter()->routeRequest('GET', $in);
    $this->assertSame($expected_responder, $actual_responder);
    $this->assertEquals(
      $expected_data->toArray(),
      $actual_data->toArray(),
    );
  }

  /**
   * @expectedException \FredEmmott\HackRouter\NotFoundException
   */
  public function testNotFound(): void {
    $this->getRouter()->routeRequest('GET', '/__404');
  }

  /**
   * @expectedException \FredEmmott\HackRouter\MethodNotAllowedException
   */
  public function testMethodNotAllowed(): void {
    $this->getRouter()->routeRequest('POST', '/foo');
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
