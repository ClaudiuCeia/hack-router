<?hh

namespace FredEmmott\HackRouter\Tests;

use FredEmmott\HackRouter\URIMap;
use FredEmmott\HackRouter\URIPart;
use FredEmmott\HackRouter\URIParam;

class GenerationTest extends \PHPUnit_Framework_TestCase {
  public function partsProvider(): array<string, (Iterable<URIPart>, string, string)> {
    return [
      'no parts' => tuple(
        Vector {},
        '#^//?$#',
        '/',
      ),
      'one part' => tuple(
        Vector { URIPart::string('foo') },
        '#^/foo/?$#',
        '/foo',
      ),
      'two part' => tuple(
        Vector {URIPart::string('foo'), URIPart::string('bar')},
        '#^/foo/bar/?$#',
        '/foo/bar',
      ),
      'int param' => tuple(
        Vector {URIPart::string('post'), URIParam::int('id')},
        '#^/post/(?<id>\d+)/?$#',
        '/post/{id:\d+}'
      ),
      'string param' => tuple(
        Vector {URIPart::string('user'), URIParam::string('username')},
        '#^/user/(?<username>[^/]+)/?$#',
        '/user/{username:[^/]+}',
      ),
      'enum param' => tuple(
        Vector {URIParam::enum('foo', Set { 'herp', 'derp' }) },
        '#^/(?<foo>(?:herp|derp))/?$#',
        '/{foo:(?:herp|derp)}',
      ),
    ];
  }

  /**
   * @dataProvider partsProvider
   */
  public function testRegexpGeneration(
    Iterable<URIPart> $parts,
    string $expected_regexp,
    string $expected_fastroute,
  ): void {
    $actual_regexp = URIMap::generateRegexpForParts($parts);
    $this->assertSame($expected_regexp, $actual_regexp);
  }

  /**
   * @dataProvider partsProvider
   */
  public function testFastRouteGeneration(
    \ConstVector<URIPart> $parts,
    string $expected_regexp,
    string $expected_fastroute,
  ): void {
    $actual_fastroute = URIMap::generateFastRouteStringForParts($parts);
    $this->assertSame($expected_fastroute, $actual_fastroute);
  }

}
