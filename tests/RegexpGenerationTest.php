<?hh

namespace FredEmmott\HackRouter\Tests;

use FredEmmott\HackRouter\URIMap;
use FredEmmott\HackRouter\URIPart;
use FredEmmott\HackRouter\URIParam;

class RegexpGenerationTest extends \PHPUnit_Framework_TestCase {
  public function partsProvider(): array<string, array<mixed>> {
    return [
      'no parts' => ['#^//?$#', Vector {} ],
      'one part' => ['#^/foo/?$#', Vector {URIPart::string('foo')} ],
      'two part' => [
        '#^/foo/bar/?$#',
        Vector {URIPart::string('foo'), URIPart::string('bar')}
      ],
      'int param' => [
        '#^/post/(?<id>\d+)/?$#',
        Vector {URIPart::string('post'), URIParam::int('id')},
      ],
      'string param' => [
        '#^/user/(?<username>[^/]+)/?$#',
        Vector {URIPart::string('user'), URIParam::string('username')},
      ],
    ];
  }

  /**
   * @dataProvider partsProvider
   */
  public function testRegexpGeneration(
    string $expected_regexp,
    \ConstVector<URIPart> $parts,
  ): void {
    $actual_regexp = URIMap::generateForParts($parts);
    $this->assertSame($expected_regexp, $actual_regexp);
  }
}
